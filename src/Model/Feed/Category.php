<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Model\Feed;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KacperWojtaszczyk\SimpleRssReader\Repository\Feed\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     * @var string
     */
    private $term;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $scheme;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $label;

    /**
     * @ORM\ManyToMany(targetEntity="Feed", inversedBy="category")
     * @ORM\JoinTable(joinColumns={@ORM\JoinColumn(referencedColumnName="term")})
     * @var Feed[]|ArrayCollection
     */
    private $feed;

    /**
     * @ORM\ManyToMany(targetEntity="Entry", inversedBy="category")
     * @ORM\JoinTable(joinColumns={@ORM\JoinColumn(referencedColumnName="term")})
     * @var Entry[]|ArrayCollection
     */
    private $entry;

    public static function withTerm(string $term): self
    {
        $self = new self;
        $self->term = $term;
        return $self;
    }

    public function getTerm(): string
    {
        return $this->term;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     * @return Category
     */
    public function setScheme(string $scheme): Category
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Category
     */
    public function setLabel(string $label): Category
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return ArrayCollection|Feed[]
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * @return ArrayCollection|Entry[]
     */
    public function getEntry()
    {
        return $this->entry;
    }

}
