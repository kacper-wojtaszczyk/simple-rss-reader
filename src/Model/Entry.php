<?php

namespace KacperWojtaszczyk\SimpleRssReader\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="KacperWojtaszczyk\SimpleRssReader\Repository\EntryRepository")
 */
class Entry
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
