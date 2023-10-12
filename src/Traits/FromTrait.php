<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Interfaces\ValueObjectInterface;
use Costa\Entity\Utils\ParameterUtil;
use DateTime;
use DateTimeInterface;
use Exception;
use ReflectionClass;
use ReflectionException;
use Throwable;

trait FromTrait
{
    use MethodTrait;

    public static function from(mixed ...$payloads): static
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