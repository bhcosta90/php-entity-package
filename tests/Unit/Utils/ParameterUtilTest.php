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
                "name" => "name",
                "type" => "string",
            ],
        ], $this->parameter->getConstructorProperties());
    });

    test("get all parameters", function () {
        assertEquals([
            [
                "name" => "name",
                "type" => "string",
            ],
            [
                "name" => "id",
                "type" => Uuid::class,
            ],
            [
                "name" => "createdAt",
                "type" => DateTimeInterface::class,
            ],
            [
                "name" => "updatedAt",
                "type" => DateTimeInterface::class,
            ],
        ], $this->parameter->getProperties());
    });
});