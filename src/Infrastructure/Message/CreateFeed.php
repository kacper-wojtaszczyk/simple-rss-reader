<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Message;

final class CreateFeed
{
    /**
     * @var string
     */
    private $url;

    public static function forUrl(string $url): self
    {
        $self = new self();
        $self->url = $url;
        return $self;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

}