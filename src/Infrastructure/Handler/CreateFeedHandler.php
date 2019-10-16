<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Handler;

use Doctrine\ORM\EntityManager;
use GuzzleHttp\ClientInterface;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\GatewayInterface;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Mapper\EntryMapper;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Mapper\FeedMapper;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Message\CreateFeed;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Entry;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Exception\FeedAlreadyExistsException;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Exception\FeedNotExistsException;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Feed;
use KacperWojtaszczyk\SimpleRssReader\Repository\Feed\FeedRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Message\RefreshFeed;
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

    public function __construct(GatewayInterface $gateway, FeedRepository $feedRepository,
                                EntityManager $em, MessageBusInterface $bus)
    {
        $this->gateway = $gateway;
        $this->em = $em;
        $this->feedRepository = $feedRepository;
        $this->bus = $bus;
    }

    public function __invoke(CreateFeed $message)
    {
        try {
            $feedDTO = $this->gateway->requestFeed($message->getUrl());
            if($this->feedRepository->find($feedDTO->id))
            {
                throw FeedAlreadyExistsException::withFeedId($feedDTO->id);
            }
            $feedMapper = new FeedMapper();
            $feed = $feedMapper->map($feedDTO, Feed::withIdAndUrl($feedDTO->id, $message->getUrl()));
            $this->em->persist($feed);
            $entryMapper = new EntryMapper();
            var_dump($feedDTO);
            foreach($feedDTO->entry as $entryDTO)
            {

                $entry = $entryMapper->map($entryDTO, Entry::withIdAndFeed($entryDTO->id, $feed));
                $this->em->persist($entry);
            }
            $this->em->flush();
        } finally {
            $newMessage = RefreshFeed::forFeed($feedDTO->id);
            $this->bus->dispatch($newMessage, [new DelayStamp(210000)]);
        }

    }
}