<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model;

use Doctrine\Common\Collections\ArrayCollection;


// DTO to allow line-by-line parsing of feed

class Category
{
    /**
     * @var string
     */
    public $term;

    /**
     * @var string
     */
    public $scheme;

    /**
     * @var string
     */
    public $label;

}
