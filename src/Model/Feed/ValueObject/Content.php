<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject;

use KacperWojtaszczyk\SimpleRssReader\Model\ValueObject;

class Content implements ValueObject
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $text;
    /**
     * @var string
     */
    private $src;

    public static function fromData(string $type, string $text, string $src)
    {
        $self = new self;
        $self->type = $type;
        $self->text = $text;
        $self->src = $src;
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self
            && (
                $this->getType() === $other->getType()
                && $this->getText() === $other->getText()
                && $this->getSrc() === $other->getSrc()
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
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getSrc(): string
    {
        return $this->src;
    }

}