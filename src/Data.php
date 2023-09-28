<?php

declare(strict_types=1);

namespace Costa\Entity;

use Carbon\Carbon;
use Costa\Entity\Traits\FromTrait;
use Costa\Entity\Traits\MethodMagicsTrait;
use Costa\Entity\ValueObject\Uuid;

abstract class Data
{
    use MethodMagicsTrait;
    use FromTrait;

    public function update(...$data): void
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable())) {
                $this->{$key} = $value;
            }
        }
    }

    protected readonly Uuid $id;

    protected readonly Carbon $createdAt;

    protected Carbon $updatedAt;

    protected function fillable(): array
    {
        return [];
    }

    protected function generateId(): Uuid
    {
        return Uuid::make();
    }

    protected function generateCreatedAt(): Carbon
    {
        return Carbon::now();
    }

    protected function generateUpdatedAt(): Carbon
    {
        return Carbon::now();
    }

    protected function setId(string $id): self
    {
        $this->id = new Uuid($id);
        return $this;
    }

    protected function setCreatedAt(string $date): self
    {
        $this->createdAt = Carbon::now()->parse($date);
        return $this;
    }

    protected function setUpdatedAt(string $date): self
    {
        $this->updatedAt = Carbon::now()->parse($date);
        return $this;
    }

}