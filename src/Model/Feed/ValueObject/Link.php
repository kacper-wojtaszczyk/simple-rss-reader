<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject;

use KacperWojtaszczyk\SimpleRssReader\Model\ValueObject;

class Link implements ValueObject
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $rel;
    /**
     * @var string
     */
    private $href;

    public static function fromData(string $type, string $rel, string $href)
    {
        $self = new self;
        $self->type = $type;
        $self->rel = $rel;
        $self->href = $href;
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self
            && (
                $this->getType() === $other->getType()
                && $this->getRel() === $other->getRel()
                && $this->getHref() === $other->getHref()
            );
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getRel(): string
    {
        return $this->rel;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

}