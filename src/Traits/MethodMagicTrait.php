<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Exceptions\PropertyException;

trait MethodMagicTrait
{
    /**
     * @throws PropertyException
     */
    public function __get($property)
    {
        if ($action = $this->verifyExistAction($property, "generate")) {
            $this->{$property} = $this->$action();
        }

        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        $className = get_class($this);
        throw new PropertyException("Property {$property} not found in class {$className}");
    }

    protected function verifyExistAction($property, $action): ?string
    {
        return method_exists($this, $action = $action . ucwords($property))
        && property_exists($this, $property) && empty($this->{$property}) ? $action : null;
    }
}