<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

trait MethodTrait
{
    protected static function convertUcWords(string $property): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
    }

    protected static function verifyExistAction($class, $property, $action): ?string
    {
        return method_exists($class, $action = $action . ucwords($property))
        && property_exists($class, $property) && empty($class->{$property}) ? $action : null;
    }
}