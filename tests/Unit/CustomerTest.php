<?php

use Costa\Entity\Data;
use Costa\Entity\Exceptions\ValidationException;
use Stubs\Customer;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

describe("Customer Unit Test", function () {
    test("Given a new entity", function () {
        $customer = new Customer(
            name: 'testing'
        );

        assertInstanceOf(Data::class, $customer);
    });

    test("Validating a entity", function () {
        $customer = new Customer(
            name: 'testing'
        );
        assertTrue($customer->validate());
    });

    test("Array entity", function () {
        $customer = new Customer(
            name: 'testing'
        );

        assertEquals([
            'name' => 'testing',
            'id' => (string)$customer->id,
        ], $customer->toArray());
    });

    test("Exception entity", function () {
        try {
            $customer = new Customer(
                name: 't'
            );
            $customer->toArray();
            assertTrue(false);
        } catch (ValidationException $e) {
            assertEquals($e->errors(), [
                "Stubs\Customer: The Name minimum is 3",
            ]);
        }
    });
});