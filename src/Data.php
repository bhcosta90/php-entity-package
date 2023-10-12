<?php

declare(strict_types=1);

namespace Costa\Entity;

use Costa\Entity\Interfaces\DataInterface;
use Costa\Entity\Traits\FromTrait;
use Costa\Entity\Traits\MethodMagicTrait;
use Costa\Entity\ValueObject\Uuid;
use DateTime;
use DateTimeInterface;
use Exception;

abstract class Data implements DataInterface
{
    use MethodMagicTrait;
    use FromTrait;

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

    private function setId(string $id): self
    {
        $this->id = new Uuid($id);
        return $this;
    }

    /**
     * @throws Exception
     */
    private function setCreatedAt(string $date): self
    {
        $this->createdAt = new DateTime($date);
        return $this;
    }

    /**
     * @throws Exception
     */
    private function setUpdatedAt(string $date): self
    {
        $this->updatedAt = new DateTime($date);
        return $this;
    }
}