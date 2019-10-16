<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Exception\XmlNotValidException;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model\Feed as FeedDTO;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Parser\FeedParser;

class AtomGateway implements GatewayInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function requestFeed(string $url): FeedDTO
    {
        try {
            $response = $this->client->get($url);
        } catch (ClientException | ServerException $e) {
            throw XmlNotValidException::withUrl($url);
        }

        $parser = FeedParser::forResponse($url, $response);
        return $parser->parse();
    }

}