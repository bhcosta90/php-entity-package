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

            if ($valueProperty instanceof DateTimeInterface) {
                $valueProperty = $valueProperty->format('Y-m-d H:i:s');
            }

            if ($valueProperty instanceof ValueObjectInterface) {
                $valueProperty = (string)$valueProperty;
            }

            if (is_array($valueProperty)) {
                $newDataValue = [];
                foreach ($valueProperty as $value) {
                    if ($value instanceof DataInterface) {
                        $newDataValue[] = $value->toArray();
                    }

                    if ($value instanceof ValueObjectInterface) {
                        $newDataValue[] = (string)$value;
                    }
                }
                $valueProperty = $newDataValue;
            }

            if ($valueProperty instanceof DataInterface) {
                $valueProperty = $valueProperty->toArray();
            }

            $response[$key] = $valueProperty;
        }

        return $response;
    }
}