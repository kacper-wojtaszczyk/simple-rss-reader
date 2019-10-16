<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Infrastructure\Exception;

use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class MissingAtomNodeException extends UnrecoverableMessageHandlingException
{
    public static function withName(string $name): self
    {
        $message = sprintf('XML feed does not contain a `%s`  - required node.', $name);

        return new self($message);
    }
}