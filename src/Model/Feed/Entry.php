<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Model\Feed;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Content;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Link;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Person;

/**
 * @ORM\Entity(repositoryClass="KacperWojtaszczyk\SimpleRssReader\Repository\Feed\EntryRepository")
 */
class Entry
{

    // properties as per Atom specification https://tools.ietf.org/html/rfc4287#section-4.1.2
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $updated;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var Person[]|ArrayCollection
     */
    private $author;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var Link[]|ArrayCollection
     */
    private $link;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $summary;

    /**
     * @ORM\ManyToMany(targetEntity="Category", mappedBy="entry")
     * @var Category[]|ArrayCollection
     */
    private $category;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var Content
     */
    private $content;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @var Person[]|ArrayCollection
     */
    private $contributor;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $published;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $rights;


    // additional properties for internal use

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Feed", inversedBy="entry")
     * @var Feed
     */
    private $feed;


    public static function withIdAndFeed(string $id, Feed $feed): self
    {
        $self = new self;
        $self->id = $id;
        $self->feed = $feed;
        return $self;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFeed(): Feed
    {
        return $this->feed;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return Entry
     */
    public function setUpdated(\DateTime $updated): Entry
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return ArrayCollection|Person[]
     */
    public function getAuthor()
    {
        if($this->author === null)
        {
            return $this->getFeed()->getAuthor();
        }
        return $this->author;
    }

    /**
     * @param ArrayCollection|Person[] $author
     * @return Entry
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return ArrayCollection|Link[]
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param ArrayCollection|Link[] $link
     * @return Entry
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Entry
     */
    public function setTitle(string $title): Entry
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     * @return Entry
     */
    public function setSummary(string $summary): Entry
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return ArrayCollection|Category[]
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param ArrayCollection|Category[] $category
     * @return Entry
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return ArrayCollection|Content[]
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param ArrayCollection|Content[] $content
     * @return Entry
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return ArrayCollection|Person[]
     */
    public function getContributor()
    {
        return $this->contributor;
    }

    /**
     * @param ArrayCollection|Person[] $contributor
     * @return Entry
     */
    public function setContributor($contributor)
    {
        $this->contributor = $contributor;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublished(): \DateTime
    {
        return $this->published;
    }

    /**
     * @param \DateTime $published
     * @return Entry
     */
    public function setPublished(\DateTime $published): Entry
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return string
     */
    public function getRights(): string
    {
        if($this->rights === null)
        {
            return $this->getFeed()->getRights();
        }
        return $this->rights;
    }

    /**
     * @param string $rights
     * @return Entry
     */
    public function setRights(string $rights): Entry
    {
        $this->rights = $rights;
        return $this;
    }


}
