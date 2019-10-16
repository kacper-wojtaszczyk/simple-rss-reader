<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Exception\XmlNotValidException;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Parser\FeedParser;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Feed;
use KacperWojtaszczyk\SimpleRssReader\Repository\Feed\FeedRepository;

class FeedGateway
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var FeedRepository
     */
    private $feedRepository;

    public function __construct(Client $client, FeedRepository $feedRepository)
    {
        $this->client = $client;
        $this->feedRepository = $feedRepository;
    }

    public function requestFeed(string $url): Feed
    {
        try{
            $response = $this->client->get($url);
            $parser = FeedParser::forResponse($url, $response);
            return $parser->parse();

        } catch (ClientException | ServerException $e) {
            throw XmlNotValidException::withUrl($url);
        }
    }

}