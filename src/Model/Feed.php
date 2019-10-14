<?php

namespace KacperWojtaszczyk\SimpleRssReader\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KacperWojtaszczyk\SimpleRssReader\Repository\FeedRepository")
 */
class Feed
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="uuid_binary")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
