<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

trait NotificationTrait
{
    protected array $__notification = [];

    public function addError(string $type, string $message): void
    {
        $this->__notification['error'][] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    public function hasError(): bool
    {
        return (bool) count($this->__notification['error'] ?? []);
    }

    public function errors(): array
    {
        return $this->__notification['error'] ?? [];
    }
}