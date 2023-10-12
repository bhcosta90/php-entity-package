<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Data;
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
            $payloadsConstructor[$property['value']] = $payloads[$property['value']];

            try {
                $class = new ReflectionClass($property['type']);
                if (in_array(DataInterface::class, array_keys($class->getInterfaces()))) {
                    $classData = "\\" . $class->getName();
                    $payloadsConstructor[$property['value']] = $classData::from(...$payloads[$property['value']]);
                }
            } catch (Throwable) {
            }
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