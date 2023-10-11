<?php

use Costa\Entity\Data;
use Stubs\Customer;
use Stubs\Order;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

describe("Order Unit Test", function () {
    test("Given a new entity", function () {
        $customer = new Order(
            customer: new Customer(name: 'testing'),
            items: [],
        );

        assertInstanceOf(Data::class, $customer);
    });

    test("Validating a entity", function () {
        $customer = new Order(
            customer: new Customer(name: 'testing'),
            items: [],
        );
        assertTrue($customer->validate());
    });

    test("Array entity", function () {
        $order = new Order(
            customer: $customer = new Customer(name: 'testing'),
            items: [],
        );

        assertEquals([
            'customer' => [
                'name' => 'testing',
                "id" => (string)$customer->id,
            ],
            'items' => [],
            "id" => (string)$order->id,
        ], $order->toArray());
    });
});