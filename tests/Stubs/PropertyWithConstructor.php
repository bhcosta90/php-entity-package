<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Entity\ValueObject\Uuid;
use DateTimeInterface;

class PropertyWithConstructor
{
    protected readonly Uuid $id;

    protected readonly DateTimeInterface $createdAt;

    protected DateTimeInterface $updatedAt;

    public function __construct(public string $name)
    {
    }
}