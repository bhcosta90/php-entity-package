<?php

declare(strict_types=1);

namespace Costa\Data\Traits;

use Carbon\Carbon;
use Costa\Data\Contracts\ValueObject;
use Costa\Data\Data;
use Exception;

trait toArrayTrait
{
    use ParameterTrait, MethodMagicsTrait;

    /**
     * @throws Exception
     */
    public function toArray($underscore = true): array
    {
        $response = [];

        $properties = $this->getProperties();

        foreach ($properties as $property) {
            $p = $property;

            if ($underscore) {
                $p = strtolower(preg_replace('/(?<!^)([A-Z])/', '_$1', $p));
            }

            $result = $this->__get($property);

            $result = $this->getResult($result, $underscore);

            if (is_array($result)) {
                foreach ($result as $item => $value) {
                    $result[$item] = $this->getResult($value, $underscore);
                }
            }

            $response[$p] = $result;
        }

        return $response;
    }

    /**
     * @param $result
     * @param mixed $underscore
     * @return array|mixed|string
     * @throws Exception
     */
    public function getResult($result, mixed $underscore): mixed
    {
        if ($result instanceof Data) {
            $result = $result->toArray($underscore);
        }

        if ($result instanceof ValueObject) {
            $result = (string)$result;
        }

        if ($result instanceof Carbon) {
            $result = $result->format('Y-m-d H:i:s');
        }
        return $result;
    }
}