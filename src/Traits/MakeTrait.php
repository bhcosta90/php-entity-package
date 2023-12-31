<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Support\ParameterSupport;
use Costa\Entity\ValueObject\Uuid;
use DateTime;
use DateTimeInterface;
use Exception;

trait MakeTrait
{
    use ValidateTrait;

    /**
     * @throws Exception
     */
    public static function make(mixed ...$payloads): static
    {
        if (!empty($payloads[0])) {
            $payloads = $payloads[0];
        }

        $parameters = new ParameterSupport(static::class);

        $dataConstructor = [];

        foreach ($parameters->getConstructorProperties() as $property) {
            $value = null;
            $name = self::transformName($property['value']);
            $type = $property['type'];

            if (in_array($name, array_keys($payloads))) {
                $value = $payloads[$name];
                $dataConstructor[$name] = self::transformValueInTypeProperty($type, $value);
            }
        }

        $obj = new static(...$dataConstructor);
        $obj->events = [];

        $properties = [];
        foreach ($parameters->getProperties() as $property) {
            $properties[$property['value']] = $property['type'];
        }

        foreach ($payloads as $key => $payload) {
            $key = self::transformName($key);
            $obj->{$key} = self::transformValueInTypeProperty($properties[$key], $payload);
        }

        $obj->validated();

        return $obj;
    }

    /**
     * @param $property
     * @return mixed
     */
    protected static function transformName($property): mixed
    {
        if (property_exists(static::class, $property)) {
            return $property;
        }

        $camelCaseString = str_replace('_', '', ucwords($property, '_'));
        return lcfirst($camelCaseString);
    }

    /**
     * @throws Exception
     */
    protected static function transformValueInTypeProperty($type, mixed $value): mixed
    {
        if (gettype($value) == 'string') {
            $value = match ($type) {
                Uuid::class => new Uuid($value),
                DateTimeInterface::class => new DateTime($value),
                default => $value,
            };
        }

        return $value;
    }
}
