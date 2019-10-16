<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model;

use Doctrine\Common\Collections\ArrayCollection;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Content;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Link;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Person;

// DTO to allow line-by-line parsing of feed

class Entry
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var \DateTime
     */
    public $updated;

    /**
     * @var Person[]|ArrayCollection
     */
    public $author;

    /**
     * @var Link[]|ArrayCollection
     */
    public $link;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $summary;

    /**
     * @var Category[]|ArrayCollection
     */
    public $category;

    /**
     * @var Content
     */
    public $content;

    /**
     * @var Person[]|ArrayCollection
     */
    public $contributor;

    /**
     * @var \DateTime
     */
    public $published;

    /**
     * @var string
     */
    public $rights;

    public function __construct()
    {
        $this->author = new ArrayCollection();
        $this->category = new ArrayCollection();
        $this->contributor = new ArrayCollection();
        $this->link = new ArrayCollection();
    }
}
