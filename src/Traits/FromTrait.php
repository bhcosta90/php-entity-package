<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Interfaces\DataInterface;
use Costa\Entity\Interfaces\ValueObjectInterface;
use Costa\Entity\Utils\ParameterUtil;
use DateTime;
use DateTimeInterface;
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

        $newPayload = [];
        foreach ($payloads as $key => $payload) {
            $newPayload[self::convertUcWords($key)] = $payload;
        }

        $payloads = $newPayload;

        $parameter = new ParameterUtil(static::class);

        $payloadsConstructor = [];

        foreach ($parameter->getConstructorProperties() as $property) {
            $value = $property['value'];
            $type = $property['type'];

            $payloadsConstructor[$value] = self::getPayloadWithDataInterface($type, $payloads[$value])
                ?: self::getPayloadWithEnum($type, $payloads[$value])
                    ?: self::getValueObjects($type, $payloads[$value])
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
        return null;
    }

    /**
     * @param string $type
     * @param mixed $valuePayload
     * @return null
     */
    private static function getPayloadWithEnum(string $type, mixed $valuePayload)
    {
        try {
            return $type::from($valuePayload);
        } catch (Throwable) {
            return null;
        }
    }

    private static function getValueObjects(string $type, mixed $valuePayload)
    {
        try {
            $class = new ReflectionClass($type);
            if (in_array(ValueObjectInterface::class, array_keys($class->getInterfaces()))) {
                $classData = "\\" . $class->getName();
                return new $classData($valuePayload);
            }

            if (in_array(DateTimeInterface::class, array_keys($class->getInterfaces()))) {
                return new DateTime($valuePayload);
            }
        } catch (Throwable) {
            return null;
        }
    }
}