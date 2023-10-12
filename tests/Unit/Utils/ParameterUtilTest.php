<?php

declare(strict_types=1);

use Costa\Entity\Utils\ParameterUtil;
use Costa\Entity\ValueObject\Uuid;
use Stubs\Customer;

use function PHPUnit\Framework\assertEquals;

describe("ParameterUtil Unit Test", function () {
    beforeEach(fn() => $this->parameter = new ParameterUtil(new Customer(name: 'testing')));

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
                "value" => "name",
                "type" => "string",
            ],
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
        ], $this->parameter->getProperties());
    });
});