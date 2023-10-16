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
}