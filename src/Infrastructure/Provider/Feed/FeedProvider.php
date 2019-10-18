<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Provider\Feed;


use KacperWojtaszczyk\SimpleRssReader\Model\Feed\Feed;

interface FeedProvider
{
    public function getFeed(): Feed;
}