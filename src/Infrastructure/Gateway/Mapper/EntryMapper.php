<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Mapper;


use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model\Entry as EntryDTO;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Entry;

final class EntryMapper
{
    public function map(EntryDTO $dto, Entry $entry): Entry
    {
        $entry
            ->setTitle($dto->title)
            ->setAuthor($dto->author)
            ->setCategory($dto->category)
            ->setContributor($dto->contributor)
            ->setContent($dto->content)
            ->setSummary($dto->summary)
            ->setLink($dto->link)
            ->setRights($dto->rights)
            ->setPublished($dto->published)
            ->setUpdated($dto->updated);

        return $entry;
    }
}