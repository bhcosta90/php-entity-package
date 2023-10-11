<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Throwable;

trait ArrayTrait
{
    use ParameterTrait;

    private array $removeProperties = ['__notification'];

    protected function generateArray(): array
    {
        $response = [];

        foreach ($this->getProperties() as $value) {
            $p = $value['name'];
            if (in_array($p, $this->removeProperties)) {
                continue;
            }

            try {
                $valueProperty = $this->{$p};
            } catch (Throwable $e) {
                $action = "generate" . ucfirst($this->convertUcWords($p));
                $valueProperty = $this->{$p} = $this->$action();
            }

            if (gettype($valueProperty) === 'object' && method_exists($valueProperty, 'toArray')) {
                $valueProperty = $valueProperty->toArray();
            }

            if (gettype($valueProperty) === 'object' && method_exists($valueProperty, '__toString')) {
                $valueProperty = $valueProperty->__toString();
            }

            $response[$p] = $valueProperty;
        }

        return $response;
    }

    protected function convertUcWords(string $property): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $property))));
    }
}