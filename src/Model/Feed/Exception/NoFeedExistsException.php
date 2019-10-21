<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Model\Feed\Exception;

use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class NoFeedExistsException extends UnrecoverableMessageHandlingException
{
    public static function create(): self
    {
        $message = sprintf('There are no feeds in your database. Use srr:feed:add command.');

        return new self($message);
    }
}