<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Model\Feed\Exception;

use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

class FeedNotExistsException extends UnrecoverableMessageHandlingException
{
    public static function withFeedId(string $feedId): self
    {
        $message = sprintf('Feed with ID `%s` does not exist.', $feedId);

        return new self($message);
    }
}