<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Model\Feed;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Link;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Person;

/**
 * @ORM\Entity(repositoryClass="KacperWojtaszczyk\SimpleRssReader\Repository\Feed\FeedRepository")
 */
class Feed
{

    // properties as per Atom specification https://tools.ietf.org/html/rfc4287#section-4.1.1
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="object", nullable=true)
     * @var Link[]|ArrayCollection
     */
    private $link;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $rights;

    /**
     * @ORM\Column(type="object", nullable=true)
     * @var Person[]|ArrayCollection
     */
    private $author;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $icon;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $subtitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $logo;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $updated;

    /**
     * @ORM\ManyToMany(targetEntity="Category", mappedBy="feed")
     * @var Category[]|ArrayCollection
     */
    private $category;

    /**
     * @ORM\Column(type="object", nullable=true)
     * @var Person[]|ArrayCollection
     */
    private $contributor;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $generator;


    // additional properties for internal use
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $lastFetched;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="feed")
     * @var Entry[]|ArrayCollection
     */
    private $entry;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="Word", mappedBy="feed")
     * @var Word[]|ArrayCollection
     */
    private $word;



    public static function withIdAndUrl(string $id, string $url): self
    {
        $self = new self;
        $self->id = $id;
        $self->url = $url;
        return $self;
    }

    public function getId(): string
    {
        return $this->id;
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
     * @return Feed
     */
    public function setTitle(string $title): Feed
    {
        $this->title = $title;
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
     * @return Feed
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getRights(): ?string
    {
        return $this->rights;
    }

    /**
     * @param string $rights
     * @return Feed
     */
    public function setRights(string $rights = null): Feed
    {
        $this->rights = $rights;
        return $this;
    }

    /**
     * @return ArrayCollection|Person[]
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param ArrayCollection|Person[] $author
     * @return Feed
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return Feed
     */
    public function setIcon(string $icon = null): Feed
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     * @return Feed
     */
    public function setSubtitle(string $subtitle = null): Feed
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     * @return Feed
     */
    public function setLogo(string $logo = null): Feed
    {
        $this->logo = $logo;
        return $this;
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
     * @return Feed
     */
    public function setUpdated(\DateTime $updated): Feed
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @return ArrayCollection|Category[]
     */
    public function getCategory(): ?ArrayCollection
    {
        return $this->category;
    }

    /**
     * @param ArrayCollection|Category[] $category
     * @return Feed
     */
    public function setCategory(ArrayCollection $category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return ArrayCollection|Person[]
     */
    public function getContributor(): ?ArrayCollection
    {
        return $this->contributor;
    }

    /**
     * @param ArrayCollection|Person[] $contributor
     * @return Feed
     */
    public function setContributor(ArrayCollection $contributor)
    {
        $this->contributor = $contributor;
        return $this;
    }

    /**
     * @return string
     */
    public function getGenerator(): ?string
    {
        return $this->generator;
    }

    /**
     * @param string $generator
     * @return Feed
     */
    public function setGenerator(string $generator = null): Feed
    {
        $this->generator = $generator;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastFetched(): \DateTime
    {
        return $this->lastFetched;
    }

    /**
     * @param \DateTime $lastFetched
     * @return Feed
     */
    public function setLastFetched(\DateTime $lastFetched): Feed
    {
        $this->lastFetched = $lastFetched;
        return $this;
    }

    /**
     * @return Entry[]|Collection
     */
    public function getEntry(): Collection
    {
        return $this->entry;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
