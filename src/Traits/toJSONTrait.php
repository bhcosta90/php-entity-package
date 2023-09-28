<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use ReflectionClass;
use ReflectionProperty;

trait toJSONTrait
{

    /**
     * @return array
     */
    public function toJSON(): string
    {
        $reflection = new ReflectionClass(static::class);
        $properties = $reflection->getProperties(
            ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED | ReflectionProperty::IS_PRIVATE
        );

        $result = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);
            try {
                $result[$property->getName()] = $property->getValue($this);
            }catch(\Throwable){

            }
        }

        return json_encode($result);
    }
}