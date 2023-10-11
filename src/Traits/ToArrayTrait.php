<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Exceptions\ValidationException;

trait ToArrayTrait
{
    use ParameterTrait;
    use NotificationTrait;

    private array $removeProperties = ['__notification'];

    /**
     * @throws ValidationException
     */
    public function toArray(): array
    {
        $response = [];

        foreach ($this->getProperties() as $value) {
            $p = $value['name'];
            if (in_array($p, $this->removeProperties)) {
                continue;
            }

            $valueProperty = $this->{$p};

            if (gettype($valueProperty) === 'object' && method_exists($valueProperty, 'toArray')) {
                $valueProperty = $valueProperty->toArray();
            }

            if (gettype($valueProperty) === 'object' && method_exists($valueProperty, 'toString')) {
                $valueProperty = $valueProperty->toString();
            }

            $response[$p] = $valueProperty;
        }

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