<?php

declare(strict_types=1);

namespace Costa\Entity;

use Costa\Entity\Interfaces\DataInterface;
use Costa\Entity\Support\NotificationSupport;
use Costa\Entity\Traits\FromTrait;
use Costa\Entity\Traits\MethodMagicTrait;
use Costa\Entity\Traits\ValidateTrait;
use Costa\Entity\ValueObject\Uuid;
use DateTime;
use DateTimeInterface;
use Exception;

abstract class Data implements DataInterface
{
    use MethodMagicTrait;
    use FromTrait;
    use ValidateTrait;

    private NotificationSupport $notification;

    protected function __construct()
    {
        $this->notification = new NotificationSupport();
    }

    protected readonly Uuid $id;

    protected readonly DateTimeInterface $createdAt;

    protected DateTimeInterface $updatedAt;

    private function generateId(): Uuid
    {
        return Uuid::make();
    }

    private function generateCreatedAt(): DateTimeInterface
    {
        return new DateTime();
    }

    private function generateUpdatedAt(): DateTimeInterface
    {
        return new DateTime();
    }
}