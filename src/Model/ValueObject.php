<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Model;

interface ValueObject
{
    public function equals(ValueObject $other): bool;
}
