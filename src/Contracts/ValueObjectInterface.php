<?php

declare(strict_types=1);

namespace Costa\Entity\Contracts;

interface ValueObjectInterface
{
    public static function make(): self;

    public function __toString(): string;
}