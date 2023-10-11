<?php

declare(strict_types=1);

namespace Costa\Entity;

use Costa\Entity\Traits\ToArrayTrait;
use Costa\Entity\Traits\ValidateTrait;
use Costa\Entity\ValueObject\Uuid;
use Exception;
use Throwable;

abstract class Data
{
    use ValidateTrait;
    use ToArrayTrait;

    protected readonly ?Uuid $id;

    private function generateId(): Uuid
    {
        return Uuid::make();
    }

    public function __get($p)
    {
        if (property_exists($this, $p)) {
            try {
                $valueProperty = $this->{$p};
            } catch (Throwable $e) {
                $action = "generate" . ucfirst($this->convertUcWords($p));
                $valueProperty = $this->{$p} = $this->$action();
            }

            return $valueProperty;
        }

        $className = get_class($this);
        throw new Exception("Property {$p} not found in class {$className}");
    }
}