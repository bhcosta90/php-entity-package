<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Exceptions\PropertyException;

trait MethodMagicTrait
{
    use MethodTrait;

    /**
     * @throws PropertyException
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw new PropertyException("Property {$property} not found in class {$className}");
    }
}