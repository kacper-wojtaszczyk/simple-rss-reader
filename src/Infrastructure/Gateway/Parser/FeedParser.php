<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Parser;

use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Exception\MissingAtomNodeException;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Exception\XmlNotValidException;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Feed;
use Psr\Http\Message\ResponseInterface;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model\Feed as FeedDTO;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model\Entry as EntryDTO;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model\Category as CategoryDTO;

final class FeedParser
{

    /**
     * @var string
     */
    private $url;

    /**
     * @var \XMLReader
     */
    private $reader;

    /**
     * @var string
     */
    private $feedId;

    /**
     * @var Feed
     */
    private $feed;

    public static function forResponse(string $url, ResponseInterface $response)
    {
        $self = new self();
        $self->url = $url;
        $self->reader = new \XMLReader();
        $body = (string)$response->getBody();
        if(!$self->reader->xml($body))
        {
            throw XmlNotValidException::withUrl($url);
        }

        return $self;
    }

    public function parse(): Feed
    {
        $this->reader->read();
        if($this->reader->name === "feed") {
            $feed = $this->parseFeed();
        } else {
            throw MissingAtomNodeException::withName("feed");
        }
        return $this->feed;
    }

    private function parseFeed()
    {
        $feed = new FeedDTO();
        while($this->reader->read())
        {
            switch ($this->reader->name) {
                case 'id':
                    $this->reader->read();
                    $feed->id = $this->reader->value;
                    break;
                case 'title':
                    $this->reader->read();
                    $feed->title = $this->reader->value;
                    break;
                case 'link':
                    $this->reader->read();
                    $feed->title = $this->reader->value;
                    break;
            }
        }
    }
}