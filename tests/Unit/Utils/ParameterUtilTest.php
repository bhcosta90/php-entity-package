<?php

declare(strict_types=1);

use Costa\Entity\Utils\ParameterUtil;
use Costa\Entity\ValueObject\Uuid;

use Stubs\PropertyWithConstructor;

use function PHPUnit\Framework\assertEquals;

describe("ParameterUtil Unit Test", function () {
    beforeEach(fn() => $this->parameter = new ParameterUtil(PropertyWithConstructor::class));

    test("get constructor parameters", function () {
        assertEquals([
            [
                "value" => "name",
                "type" => "string",
            ],
        ], $this->parameter->getConstructorProperties());
    });

    test("get all parameters", function () {
        assertEquals([
            [
                "value" => "id",
                "type" => Uuid::class,
            ],
            [
                "value" => "createdAt",
                "type" => DateTimeInterface::class,
            ],
            [
                "value" => "updatedAt",
                "type" => DateTimeInterface::class,
            ],
            [
                "value" => "name",
                "type" => "string",
            ],
        ], $this->parameter->getProperties());
    });
});