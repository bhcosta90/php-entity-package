<?php

declare(strict_types=1);

namespace Costa\Entity\ValueObject;

use Costa\Entity\Interfaces\ValueObjectInterface;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid as UuidUuid;

class Uuid implements ValueObjectInterface
{
    public function __construct(protected string $value)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (!UuidUuid::isValid($this->value)) {
            throw new InvalidArgumentException(
                sprintf('<%s> does not allow the value <%s>', static::class, $this->value)
            );
        }
    }

    public static function make(): self
    {
        return new self(UuidUuid::uuid7()->toString());
    }

    public function __toString(): string
    {
        return $this->value;
    }
}