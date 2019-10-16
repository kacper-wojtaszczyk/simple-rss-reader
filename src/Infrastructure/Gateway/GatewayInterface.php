<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway;


use KacperWojtaszczyk\SimpleRssReader\Infrastructure\Gateway\Model\Feed as FeedDTO;

interface GatewayInterface
{
    public function requestFeed(string $url): FeedDTO;
}