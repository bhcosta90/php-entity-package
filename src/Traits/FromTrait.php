<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Interfaces\DataInterface;
use Costa\Entity\Utils\ParameterUtil;
use ReflectionClass;
use Throwable;

trait FromTrait
{
    use MethodTrait;

    public static function from(mixed ...$payloads): static
    {
        if (!empty($payloads[0])) {
            $payloads = $payloads[0];
        }

        $parameter = new ParameterUtil(static::class);
//        $valuesProperties = array_map(fn($p) => $p['value'], $parameter->getConstructorProperties());
//        $payloadsConstructor = array_intersect_key($payloads, array_flip($valuesProperties));
//
//        foreach($payloadsConstructor as $key => $value) {
//            dd($payloadsConstructor);
//        }

        $payloadsConstructor = [];
        foreach ($parameter->getConstructorProperties() as $property) {
            $value = $property['value'];
            $type = $property['type'];

            $payloadsConstructor[$value] = self::getPayloadWithDataInterface($type, $payloads[$value])
                ?: $payloads[$value];
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

    public static function getPayloadWithDataInterface(string $type, mixed $valuePayload): DataInterface|null
    {
        try {
            $class = new ReflectionClass($type);
            if (in_array(DataInterface::class, array_keys($class->getInterfaces()))) {
                $classData = "\\" . $class->getName();
                return $classData::from(...$valuePayload);
            }
        } catch (Throwable) {
            return null;
        }
    }
}