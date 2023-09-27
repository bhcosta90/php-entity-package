<?php

declare(strict_types=1);

namespace Costa\Data\Traits;

trait FromTrait
{
    use MethodsTrait;
    use ParameterTrait;

    public static function from(mixed ...$payloads): static
    {
        if (!empty($payloads[0])) {
            $payloads = $payloads[0];
        }

        $propertyNames = self::getValuesOfPayloadAndSetConstructor($payloads);
        $valuesProperties = array_map(fn($p) => $p['value'], $propertyNames);

        $response = new static(...$valuesProperties);

        foreach ($payloads as $p => $v) {
            $newP = self::convertUcWords($p);
            if ((empty($response->{$p}) || empty($response->{$newP})) && $action = $response->verifyExistAction(
                    $newP,
                    "set"
                )) {
                $response->$action($v);
            }
        }

        return $response;
    }

    protected static function getValuesOfPayloadAndSetConstructor($payloads): array
    {
        return array_map(fn($parameter) => [
            'type' => $parameter->getType(),
            'value' => $payloads[$parameter->getName()],
        ], self::getConstructorParameter());
    }
}