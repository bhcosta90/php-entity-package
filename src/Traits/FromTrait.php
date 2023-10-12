<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Utils\ParameterUtil;

trait FromTrait
{
    use MethodTrait;

    public static function from(mixed ...$payloads): static
    {
        if (!empty($payloads[0])) {
            $payloads = $payloads[0];
        }

        $parameter = new ParameterUtil(static::class);
        $valuesProperties = array_map(fn($p) => $p['value'], $parameter->getConstructorProperties());
        $payloads = array_intersect_key($payloads, array_flip($valuesProperties));

        $entity = new static(...$payloads);

        foreach ($payloads as $p => $v) {
            if (empty($entity->{$p})) {
                dd($p);
            }
        }

        return $entity;
    }
}