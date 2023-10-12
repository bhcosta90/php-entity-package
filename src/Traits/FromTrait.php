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
        $payloadsConstructor = array_intersect_key($payloads, array_flip($valuesProperties));

        $entity = new static(...$payloadsConstructor);

        foreach ($payloads as $p => $v) {
            $newP = self::convertUcWords($p);

            if ((empty($entity->{$p}) || empty($entity->{$newP}))
                && $action = self::verifyExistAction($entity, $newP, "set")) {
                $entity->$action($v);
            }
        }

        return $entity;
    }
}