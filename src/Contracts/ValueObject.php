<?php

declare(strict_types=1);

namespace Costa\Entity\Contracts;

interface ValueObject
{
    public static function make(): self;

    public function __toString(): string;
}