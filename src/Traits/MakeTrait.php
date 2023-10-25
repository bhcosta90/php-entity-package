<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Support\ParameterSupport;

trait MakeTrait
{
    use ValidateTrait;

    public static function make(mixed ...$payloads): static
    {
        if (!empty($payloads[0])) {
            $payloads = $payloads[0];
        }

        $parameters = new ParameterSupport(static::class);

        $dataConstructor = [];

        foreach ($parameters->getConstructorProperties() as $property) {
            $value = null;
            $name = $property['value'];
            $type = $property['type'];

            if (in_array($name, array_keys($payloads))) {
                $value = $payloads[$name];
                $dataConstructor[$name] = self::transformValueInTypePropery($type, $value);
            }
        }

        $obj = new static(...$dataConstructor);
        $obj->events = [];

        $properties = [];
        foreach ($parameters->getProperties() as $property) {
            $properties[$property['value']] = $property['type'];
        }

        foreach ($payloads as $key => $payload) {
            if (in_array($key, ['id', 'updatedAt', 'createdAt']) && !empty($payload)) {
                $obj->{$key} = self::transformValueInTypePropery($properties[$key], $payload);
            } else {
                $obj->{$key} = $payload;
            }
        }

        $obj->validated();

        return $obj;
    }
}
