<?php

declare(strict_types=1);

namespace Costa\Data\Builder;

use Costa\Data\Data;

class DataBuilder
{
    public static function make(string $class, array $data): Data
    {
        /**
         * @var Data $class
         */
        $response = $class::from($data);
        $response->validate();

        return $response;
    }
}