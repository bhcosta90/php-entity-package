<?php

declare(strict_types=1);

namespace Costa\Data\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected array $errors = [];

    public static function withMessages(string $key, array $messages, int $status = 422): static
    {
        $class = new ValidationException("validation error", $status);

        foreach ($messages as $message) {
            $class->add($key . ": " . $message);
        }

        return $class;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function status(): int
    {
        return $this->code;
    }

    public function add($error): void
    {
        $this->errors[] = $error;
    }
}