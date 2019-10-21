<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Handler;

use Doctrine\ORM\EntityManager;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\GatewayInterface;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Mapper\EntryMapper;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Mapper\FeedMapper;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Message\CreateFeed;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Message\RefreshFeed;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Entry;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Exception\FeedAlreadyExistsException;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Feed;
use KacperWojtaszczyk\SimpleRssReader\Repository\Feed\FeedRepository;
use KacperWojtaszczyk\SimpleRssReader\Service\WordUpdateService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

final class CreateFeedHandler implements MessageHandlerInterface
{
    /**
     * @var GatewayInterface
     */
    private $gateway;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var FeedRepository
     */
    private $feedRepository;

    /**
     * @var MessageBusInterface
     */
    private $bus;
    /**
     * @var WordUpdateService
     */
    private $wordUpdateService;

    public function __construct(GatewayInterface $gateway, FeedRepository $feedRepository,
                                EntityManager $em, MessageBusInterface $bus, WordUpdateService $wordUpdateService)
    {
        $this->gateway = $gateway;
        $this->em = $em;
        $this->feedRepository = $feedRepository;
        $this->bus = $bus;
        $this->wordUpdateService = $wordUpdateService;
    }

    public function __invoke(CreateFeed $message)
    {

            $feedDTO = $this->gateway->requestFeed($message->getUrl());
            if ($this->feedRepository->find($feedDTO->id)) {
                throw FeedAlreadyExistsException::withFeedId($feedDTO->id);
            }
            $feedMapper = new FeedMapper();
            $feed = $feedMapper->map($feedDTO, Feed::withIdAndUrl($feedDTO->id, $message->getUrl()));
            $this->em->persist($feed);
            $entryMapper = new EntryMapper();
            foreach ($feedDTO->entry as $entryDTO) {
                $entry = $entryMapper->map($entryDTO, Entry::withIdAndFeed($entryDTO->id, $feed));
                $this->em->persist($entry);
                $this->wordUpdateService->forEntry($entry);
            }
            $this->em->flush();
            $newMessage = RefreshFeed::forFeed($feedDTO->id);
            $this->bus->dispatch($newMessage, [new DelayStamp(210000)]);


    }
}