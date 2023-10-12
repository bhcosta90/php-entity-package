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
    protected function getConstructorParameter(): array
    {
        $reflectionClass = $this->getReflectionClass();
        $constructor = $reflectionClass->getConstructor();
        return $constructor->getParameters();
    }

    protected function getProperties(): array
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
    protected function getReflectionClass(): ReflectionClass
    {
        return new ReflectionClass($this->class);
    }
}