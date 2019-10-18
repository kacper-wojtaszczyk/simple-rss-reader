<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Parser;

use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Exception\MissingAtomNodeException;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Exception\XmlNotValidException;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model\Entry as EntryDTO;
use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model\Feed as FeedDTO;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Category;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Content;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Link;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Person;
use Psr\Http\Message\ResponseInterface;

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

    public static function forResponse(string $url, ResponseInterface $response): self
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

    public function parse(): FeedDTO
    {
        $this->reader->read();
        if($this->reader->name === 'feed') {
            $feed = $this->parseFeed();
        } else {
            throw MissingAtomNodeException::withName('feed');
        }
        return $feed;
    }

    private function parseFeed(): FeedDTO
    {
        $feed = new FeedDTO();
        $feed->url = $this->url;
        while($this->reader->read())
        {
            if($this->reader->nodeType === \XMLReader::END_ELEMENT)
            {
                if($this->reader->name === 'feed')
                {
                    break;
                }
                continue;
            }
            switch ($this->reader->name) {
                case 'id':
                    $this->reader->read();
                    $feed->id = $this->reader->value;
                    while($this->reader->name !== 'id' && $this->reader->nodeType !== \XMLReader::END_ELEMENT){
                        $this->reader->read();
                    }
                    break;
                case 'title':
                    $this->reader->read();
                    $feed->title = $this->reader->value;
                    while($this->reader->name !== 'id' && $this->reader->nodeType !== \XMLReader::END_ELEMENT){
                        $this->reader->read();
                    }
                    break;
                case 'link':
                    $type = $this->reader->getAttribute('type');
                    $link = Link::fromData(
                        $this->reader->getAttribute('href'),
                        $this->reader->getAttribute('type'),
                        $this->reader->getAttribute('rel')
                    );
                    $feed->link->add($link);
                    break;
                case 'rights':
                    $this->reader->read();
                    $feed->rights = $this->reader->value;
                    while($this->reader->name !== 'id' && $this->reader->nodeType !== \XMLReader::END_ELEMENT){
                        $this->reader->read();
                    }
                    break;
                case 'author':
                    $author = $this->parsePerson('author');
                    $feed->author->add($author);
                    break;
                case 'icon':
                    $this->reader->read();
                    $feed->icon = $this->reader->value;
                    break;
                case 'subtitle':
                    $this->reader->read();
                    $feed->subtitle = $this->reader->value;
                    break;
                case 'logo':
                    $this->reader->read();
                    $feed->logo = $this->reader->value;
                    break;
                case 'generator':
                    $this->reader->read();
                    $feed->generator = $this->reader->value;
                    break;
                case 'updated':
                    $this->reader->read();
                    try{
                        $feed->updated = new \DateTime($this->reader->value);
                    } catch(\Exception $e) {
                        $feed->updated = \DateTime::createFromFormat("Y-m-d\TH:i:s.uP", "2017-07-25T15:25:16.123456+02:00");
                    }

                    break;
                case 'category':
                    $category = Category::withTerm($this->reader->getAttribute('term'));
                    $category
                        ->setScheme($this->reader->getAttribute('scheme'))
                        ->setLabel($this->reader->getAttribute('label'));
                    $feed->category->add($category);
                    break;
                case 'contributor':
                    $contributor = $this->parsePerson('contributor');
                    $feed->contributor->add($contributor);
                    break;
                case 'entry':
                    $feed->entry->add($this->parseEntry());
                    break;
            }
        }
        return $feed;
    }
    private function parsePerson(string $tag): Person
    {
        $data = ['name' => null, 'uri' => null, 'email' => null];
        while($this->reader->read())
        {

            if($this->reader->nodeType === \XMLReader::END_ELEMENT)
            {
                if($this->reader->name === $tag)
                {
                    break;
                }
                continue;
            }
            switch ($this->reader->name) {
                case 'name':
                    $this->reader->read();
                    $data['name'] = $this->reader->value;
                    break;
                case 'email':
                    $this->reader->read();
                    $data['email'] = $this->reader->value;
                    break;
                case 'uri':
                    $this->reader->read();
                    $data['uri'] = $this->reader->value;
                    break;
            }
        }
        return Person::fromData($data['name'], $data['email'], $data['uri']);
    }

    private function parseEntry(): EntryDTO
    {
        $entry = new EntryDTO();
        while($this->reader->read())
        {
            if($this->reader->nodeType === \XMLReader::END_ELEMENT)
            {
                if($this->reader->name === 'entry')
                {
                    break;
                }
                continue;
            }
            switch ($this->reader->name) {
                case 'id':
                    $this->reader->read();
                    $entry->id = $this->reader->value;
                    break;
                case 'title':
                    $this->reader->read();
                    $entry->title = $this->reader->value;
                    break;
                case 'link':
                    $link = Link::fromData(
                        $this->reader->getAttribute('href'),
                        $this->reader->getAttribute('rel'),
                        $this->reader->getAttribute('type')
                    );
                    $entry->link->add($link);
                    break;
                case 'rights':
                    $this->reader->read();
                    $entry->rights = $this->reader->value;
                    break;
                case 'author':
                    $author = $this->parsePerson('author');
                    $entry->author->add($author);
                    break;
                case 'updated':
                    $this->reader->read();
                    try{
                        $entry->updated = new \DateTime($this->reader->value);
                    } catch(\Exception $e) {
                        $entry->updated = \DateTime::createFromFormat("Y-m-d\TH:i:s.uP", "2017-07-25T15:25:16.123456+02:00");
                    }
                    break;
                case 'category':
                    $category = Category::withTerm($this->reader->getAttribute('term'));
                    $category
                        ->setScheme($this->reader->getAttribute('scheme'))
                        ->setLabel($this->reader->getAttribute('label'));
                    $entry->category->add($category);
                    break;
                case 'contributor':
                    $contributor = $this->parsePerson('contributor');
                    $entry->author->add($contributor);
                    break;
                case 'published':
                    $this->reader->read();
                    try{
                        $entry->published = new \DateTime($this->reader->value);
                    } catch(\Exception $e) {
                        $entry->published = \DateTime::createFromFormat("Y-m-d\TH:i:s.uP", "2017-07-25T15:25:16.123456+02:00");
                    }
                    break;
                case 'summary':
                    $this->reader->read();
                    $entry->summary = $this->reader->value;
                    break;
                case 'content':
                    if($this->reader->getAttribute('src'))
                    {
                        $content = Content::fromData(
                            $this->reader->getAttribute('type'),
                            '',
                            $this->reader->getAttribute('src')
                        );
                    } else
                    {
                        $content = Content::fromData(
                            $this->reader->getAttribute('type'),
                            $this->reader->read() ? $this->reader->value : '',
                            ''
                        );
                    }
                    $entry->content = $content;
                    break;
            }
        }
        return $entry;
    }
}