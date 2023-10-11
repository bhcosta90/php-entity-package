<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\ValueObject\Uuid;
use DateTime;
use DateTimeInterface;

trait EntityTrait
{
    protected Uuid $id;

    protected DateTimeInterface $createdAt;

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