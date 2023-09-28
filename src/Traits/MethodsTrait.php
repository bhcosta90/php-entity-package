<?php

declare(strict_types=1);

namespace Costa\Data\Traits;

trait MethodsTrait
{
    public static function convertUcWords(string $property): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
    }

    public function verifyExistAction($property, $action): ?string
    {
        return method_exists(static::class, $action = $action . ucwords($property))
        && property_exists($this, $property) && empty($this->{$property}) ? $action : null;
    }
}