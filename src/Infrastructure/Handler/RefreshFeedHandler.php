<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Handler;

use GuzzleHttp\ClientInterface;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Exception\FeedNotExistsException;
use KacperWojtaszczyk\SimpleRssReader\Repository\Feed\FeedRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Message\RefreshFeed;

final class RefreshFeedHandler implements MessageHandlerInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var FeedRepository
     */
    private $feedRepository;

    public function __construct(ClientInterface $client, FeedRepository $feedRepository)
    {
        $this->client = $client;
        $this->feedRepository = $feedRepository;
    }

    public function __invoke(RefreshFeed $message)
    {
        $feed = $this->feedRepository->find($message->getFeedId());
        $this->feedRepository;

//        if ($feed === null) {
//            throw FeedNotExistsException::withFeedId($message->getFeedId());
//        }
//
//        try {
//            //$feed->sendStatusNotification($this->client);
//        } finally {
//            $this->sessionCollection->save($feed);
//        }
    }
}