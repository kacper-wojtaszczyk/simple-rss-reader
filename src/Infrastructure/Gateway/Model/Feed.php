<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model;

use Doctrine\Common\Collections\ArrayCollection;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Link;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject\Person;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Category;

// DTO to allow line-by-line parsing of feed

class Feed
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var Link[]|ArrayCollection
     */
    public $link;

    /**
     * @var string
     */
    public $rights;

    /**
     * @var Person[]|ArrayCollection
     */
    public $author;

    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */
    public $subtitle;

    /**
     * @var string
     */
    public $logo;

    /**
     * @var \DateTime
     */
    public $updated;

    /**
     * @var Category[]|ArrayCollection
     */
    public $category;

    /**
     * @var Person[]|ArrayCollection
     */
    public $contributor;

    /**
     * @var string
     */
    public $generator;

    /**
     * @var Entry[]|ArrayCollection
     */
    private $entry;

    public function __construct()
    {
        $this->author = new ArrayCollection();
        $this->category = new ArrayCollection();
        $this->contributor = new ArrayCollection();
        $this->link = new ArrayCollection();
        $this->entry = new ArrayCollection();
    }

}
