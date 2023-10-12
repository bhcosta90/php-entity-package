<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

trait MethodTrait
{
    protected function verifyExistAction($property, $action): ?string
    {
        return method_exists($this, $action = $action . ucwords($property))
        && property_exists($this, $property) && empty($this->{$property}) ? $action : null;
    }
}