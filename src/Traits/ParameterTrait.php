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
    public static function getConstructorParameter(): array
    {
        $reflectionClass = self::getReflectionClass();
        $constructor = $reflectionClass->getConstructor();
        return $constructor->getParameters();
    }

    public function getProperties(): array
    {
        $reflectionClass = self::getReflectionClass();
        $properties = $reflectionClass->getProperties();

        $response = [];

        foreach ($properties as $propriedade) {
            $response[] = $propriedade->getName();
        }

        return $response;
    }

    /**
     * @return ReflectionClass
     */
    public static function getReflectionClass(): ReflectionClass
    {
        return new ReflectionClass(static::class);
    }

}