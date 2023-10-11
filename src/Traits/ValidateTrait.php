<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Exceptions\ValidationException;
use Costa\Entity\Validator\RakitValidation;

trait ValidateTrait
{
    use NotificationTrait;

    /**
     * @throws ValidationException
     */
    public function validate(?array $data = null): bool
    {
        if ($data === null) {
            $data = $this->toArray();
        }

        $response = RakitValidation::validate($data, $this->rules());

        foreach ($response as $error) {
            $this->addError(static::class, $error);
        }

        return !count($response);
    }

    protected abstract function toArray(): array;

    protected function rules(): array
    {
        return [];
    }
}