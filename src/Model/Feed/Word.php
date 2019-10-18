<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Model\Feed;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KacperWojtaszczyk\SimpleRssReader\Repository\Feed\EntryRepository")
 */
class Word
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     * @var string
     */
    private $word;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $count;

    /**
     * @ORM\ManyToOne(targetEntity="Feed", inversedBy="word")
     * @var Feed
     */
    private $feed;

    public static function withWord($word): self
    {
        $self = new self;
        $self->word = $word;
        $self->count = 0;
        return $self;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return self
     */
    public function addCount(int $add): self
    {
        $this->count += $add;
        return $this;
    }
}
