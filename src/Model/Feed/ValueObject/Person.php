<?php
declare(strict_types=1);

namespace KacperWojtaszczyk\SimpleRssReader\Model\Feed\ValueObject;

use KacperWojtaszczyk\SimpleRssReader\Model\ValueObject;

class Person implements ValueObject
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $uri;

    public static function fromData(string $name, string $email = null, string $uri = null): self
    {
        $self = new self;
        $self->name = $name;
        $self->email = $email;
        $self->uri = $uri;
        return $self;
    }

    public function equals(ValueObject $other): bool
    {
        return $other instanceof self
            && (
                $this->getName() === $other->getName()
                && $this->getEmail() === $other->getEmail()
                && $this->getUri() === $other->getUri()
            );
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

}