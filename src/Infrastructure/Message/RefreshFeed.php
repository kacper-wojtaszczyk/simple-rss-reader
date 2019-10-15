<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Message;

final class RefreshFeed
{
    private $feedId;

    public static function forFeed(int $feedId): self
    {
        $self = new self();
        $self->feedId = $feedId;
        return $self;
    }
}