<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Handler;

use Doctrine\ORM\EntityManager;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\GatewayInterface;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Mapper\EntryMapper;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Mapper\FeedMapper;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Message\RefreshFeed;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Entry;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Exception\FeedNotExistsException;
use KacperWojtaszczyk\SimpleRssReader\Repository\Feed\EntryRepository;
use KacperWojtaszczyk\SimpleRssReader\Repository\Feed\FeedRepository;
use KacperWojtaszczyk\SimpleRssReader\Service\WordUpdateService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

final class RefreshFeedHandler implements MessageHandlerInterface
{
    /**
     * @var FeedRepository
     */
    private $feedRepository;

    /**
     * @var GatewayInterface
     */
    private $gateway;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var EntryRepository
     */
    private $entryRepository;

    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * @var WordUpdateService
     */
    private $wordUpdateService;

    public function __construct(GatewayInterface $gateway, EntryRepository $entryRepository, FeedRepository $feedRepository,
                                EntityManager $em, MessageBusInterface $bus, WordUpdateService $wordUpdateService)
    {
        $this->gateway = $gateway;
        $this->feedRepository = $feedRepository;
        $this->em = $em;
        $this->entryRepository = $entryRepository;
        $this->bus = $bus;
        $this->wordUpdateService = $wordUpdateService;
    }

    public function __invoke(RefreshFeed $message)
    {
        $feed = $this->feedRepository->find($message->getFeedId());
        try {

            if ($feed === null) {
                throw FeedNotExistsException::withFeedId($message->getFeedId());
            }

            $feedDTO = $this->gateway->requestFeed($feed->getUrl());
            $feedMapper = new FeedMapper();
            $feed = $feedMapper->map($feedDTO, $feed);
            $this->em->persist($feed);
            $entryMapper = new EntryMapper();
            foreach ($feedDTO->entry as $entryDTO) {
                if ($entry = $this->entryRepository->findOneById($entryDTO->id, $feed)) {
                    $entry = $entryMapper->map($entryDTO, $entry);
                    $this->em->persist($entry);
                } else {
                    $entry = $entryMapper->map($entryDTO, Entry::withIdAndFeed($entryDTO->id, $feed));
                    $this->em->persist($entry);
                    $this->wordUpdateService->forEntry($entry);
                }
            }
            $this->em->flush();
        }
        finally {
                $newMessage = RefreshFeed::forFeed($feed->getId());
                $this->bus->dispatch($newMessage, [new DelayStamp(120000)]);
        }
    }
}