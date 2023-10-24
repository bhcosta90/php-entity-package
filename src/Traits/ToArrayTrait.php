<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Contracts\DataInterface;
use Costa\Entity\Contracts\ValueObjectInterface;
use Costa\Entity\Support\ParameterSupport;
use DateTimeInterface;

trait ToArrayTrait
{
    public function toArray(): array
    {
        $parameters = new ParameterSupport(static::class);

        $response = [];
        foreach ($parameters->getProperties() as $property) {
            $key = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $property['value']));

            $valueProperty = $this->{$property['value']};


            $valueProperty = match (true) {
                $valueProperty instanceof DateTimeInterface => $valueProperty->format('Y-m-d H:i:s'),
                $valueProperty instanceof ValueObjectInterface => (string)$valueProperty,
                is_array($valueProperty) => (function () use ($valueProperty) {
                    $newDataValue = [];
                    foreach ($valueProperty as $value) {
                        if ($value instanceof DataInterface) {
                            $newDataValue[] = $value->toArray();
                        }

                        if ($value instanceof ValueObjectInterface) {
                            $newDataValue[] = (string)$value;
                        }
                    }
                    return $newDataValue;
                })(),
                $valueProperty instanceof DataInterface => $valueProperty->toArray(),
                default => is_object($valueProperty) && property_exists($valueProperty, 'value')
                    ? $valueProperty->value
                    : $valueProperty,
            };

            $response[$key] = $valueProperty;
        }

        return $response;
    }
}