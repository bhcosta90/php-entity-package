<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Exceptions\ValidationException;

trait ToArrayTrait
{
    use NotificationTrait;
    use ArrayTrait;

    /**
     * @throws ValidationException
     */
    public function toArray(): array
    {
        $response = $this->generateArray();

        if (method_exists($this, 'validate')) {
            $total = $this->validate($response);

            if (!$total && $this->hasError()) {
                throw ValidationException::withMessages(
                    static::class,
                    array_map(fn($e) => $e['message'], $this->errors())
                );
            }
        }

        return $response;
    }
}