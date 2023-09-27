<?php

declare(strict_types=1);

namespace Costa\Data\Traits;

use Exception;

trait MethodMagicsTrait
{
    use MethodsTrait;

    /**
     * @throws Exception
     */
    public function __get($property)
    {
        if ($action = $this->verifyExistAction($property, "generate")) {
            $this->{$property} = $this->$action();
        }

        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        $newProperty = $this->convertUcWords($property);

        if (property_exists($this, $newProperty)) {
            return $this->{$newProperty};
        }

        $className = get_class($this);
        throw new Exception("Property {$property} not found in class {$className}");
    }
}