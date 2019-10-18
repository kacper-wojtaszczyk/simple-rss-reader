<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Message;

final class RefreshFeed
{
    /**
     * @var string
     */
    private $feedId;

    public static function forFeed(string $feedId): self
    {
        $self = new self();
        $self->feedId = $feedId;
        return $self;
    }

    /**
     * @return string
     */
    public function getFeedId(): string
    {
        return $this->feedId;
    }

}