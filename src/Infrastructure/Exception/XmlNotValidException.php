<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Exception;

use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class XmlNotValidException extends UnrecoverableMessageHandlingException
{
    public static function withUrl(string $url): self
    {
        $message = sprintf('URL `%s` does not contain a valid XML feed.', $url);

        return new self($message);
    }
}