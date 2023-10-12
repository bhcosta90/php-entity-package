<?php

declare(strict_types=1);

namespace Costa\Entity\Utils;

use ReflectionClass;
use ReflectionParameter;

final class ParameterUtil
{
    public function __construct(protected object $class)
    {
        //
    }

    /**
     * @return ReflectionParameter[]
     */
    public function getConstructorProperties(): array
    {
        $reflectionClass = $this->getReflectionClass();
        $constructor = $reflectionClass->getConstructor();
        return array_map(fn($property) => [
            'name' => $property->getName(),
            'type' => $property->getType()->getName(),
        ], $constructor->getParameters());
    }

    public function getProperties(): array
    {
        $reflectionClass = $this->getReflectionClass();
        return array_map(fn($property) => [
            'name' => $property->getName(),
            'type' => $property->getType()->getName(),
        ], $reflectionClass->getProperties());
    }

    /**
     * @return ReflectionClass
     */
    public function getReflectionClass(): ReflectionClass
    {
        return new ReflectionClass($this->class);
    }
}