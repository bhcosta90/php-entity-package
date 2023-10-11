<?php

declare(strict_types=1);

namespace Costa\Entity;

use Costa\Entity\Traits\MethodMagicTrait;
use Costa\Entity\ValueObject\Uuid;
use DateTime;
use DateTimeInterface;

abstract class Data
{
    use MethodMagicTrait;
    protected readonly Uuid $id;

    protected readonly DateTimeInterface $createdAt;

    protected DateTimeInterface $updatedAt;

    protected function generateId(): Uuid
    {
        return Uuid::make();
    }

    protected function generateCreatedAt(): DateTimeInterface
    {
        return new DateTime();
    }

    protected function generateUpdatedAt(): DateTimeInterface
    {
        return new DateTime();
    }
}