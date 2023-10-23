<?php

declare(strict_types=1);

namespace Costa\Entity\Contracts;

interface EventInterface
{
    public function payload(): array;
}