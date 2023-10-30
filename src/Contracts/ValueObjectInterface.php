<?php

declare(strict_types=1);

namespace Costa\Entity\Contracts;

interface ValueObjectInterface
{
    public function __toString(): string;
}