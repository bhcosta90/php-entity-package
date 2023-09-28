<?php

declare(strict_types=1);

namespace Costa\Data\Traits;

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

    /**
     * @return ReflectionClass
     */
    protected static function getReflectionClass(): ReflectionClass
    {
        return new ReflectionClass(static::class);
    }

    protected function getProperties(): array
    {
        $reflectionClass = self::getReflectionClass();
        $properties = $reflectionClass->getProperties();

        $response = [];

        foreach ($properties as $propriedade) {
            $response[] = $propriedade->getName();
        }

        return $response;
    }

}