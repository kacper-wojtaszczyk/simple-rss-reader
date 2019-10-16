<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Mapper;


use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model\Feed as FeedDTO;
use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Feed;

final class FeedMapper
{
    public function map(FeedDTO $dto, Feed $feed): Feed
    {
        $feed
            ->setTitle($dto->title)
            ->setAuthor($dto->author)
            ->setCategory($dto->category)
            ->setContributor($dto->contributor)
            ->setGenerator($dto->generator)
            ->setIcon($dto->icon)
            ->setLink($dto->link)
            ->setLogo($dto->logo)
            ->setRights($dto->rights)
            ->setSubtitle($dto->subtitle)
            ->setUpdated($dto->updated)
            ->setLastFetched(new \DateTime());

        return $feed;
    }
}