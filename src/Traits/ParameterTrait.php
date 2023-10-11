<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use ReflectionClass;
use ReflectionParameter;

trait ParameterTrait
{
    /**
     * @return ReflectionParameter[]
     */
    protected static function getConstructorParameter(): array
    {
        $reflectionClass = self::getReflectionClass();
        $constructor = $reflectionClass->getConstructor();
        return $constructor->getParameters();
    }

    protected static function getProperties(): array
    {
        $reflectionClass = self::getReflectionClass();
        return array_map(fn($property) => [
            'name' => $property->getName(),
            'type' => $property->getType()->getName(),
        ], $reflectionClass->getProperties());
    }

    /**
     * @return ReflectionClass
     */
    private static function getReflectionClass(): ReflectionClass
    {
        return new ReflectionClass(static::class);
    }
}