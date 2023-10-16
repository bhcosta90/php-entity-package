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

        $obj = new static();

        foreach ($payloads as $k => $payload) {
            $k = self::convertUcWords($k);
            $obj->{$k} = $payload;
        }

        $parameter = new ParameterUtil(static::class);

        foreach ($parameter->getProperties() as $properties) {
            $property = self::convertUcWords($properties['value']);
            if (empty($obj->{$property}) && ($action = self::verifyExistAction($obj, $property, "generate"))) {
                $obj->{$property} = $obj->$action();
            }
        }

        $obj->validated();

        return $obj;
    }

    public static function fromOld(mixed ...$payloads): static
    {
        if (!empty($payloads[0])) {
            $payloads = $payloads[0];
        }

        $newPayload = [];
        foreach ($payloads as $key => $payload) {
            $newPayload[self::convertUcWords($key)] = $payload;
        }

        $payloads = $newPayload;

        $parameter = new ParameterUtil(static::class);

        $payloadsConstructor = [];

        foreach ($parameter->getConstructorProperties() as $property) {
            $value = $property['value'];
            $payloadsConstructor[$value] = $payloads[$value];
        }

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