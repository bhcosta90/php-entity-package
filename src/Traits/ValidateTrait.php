<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Exceptions\NotificationException;
use Costa\Entity\Factory\ValidatorFactory;
use Costa\Entity\Utils\ParameterUtil;
use Throwable;

trait ValidateTrait
{

    /**
     * @throws NotificationException
     */
    protected function validated(): void
    {
        $parameter = new ParameterUtil(static::class);
        $data = [];

        foreach ($parameter->getProperties() as $property) {
            $prop = $property['value'];
            try {
                $data[$property['value']] = $this->{$prop};
            } catch (Throwable) {
            }
        }

        if ($errors = ValidatorFactory::make($data, $this->rules())) {
            array_map(fn($error) => $this->notification->push(static::class, $error), $errors);

            if ($this->notification->has()) {
                throw new NotificationException($this->notification->messages());
            }
        }
    }

    protected function rules(): array
    {
        return [];
    }
}