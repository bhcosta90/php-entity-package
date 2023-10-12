<?php

declare(strict_types=1);

use Costa\Entity\Data;
use Stubs\Customer;
use Stubs\Enum\Status;
use Stubs\Item;
use Stubs\Order;

use function PHPUnit\Framework\assertInstanceOf;

describe("Order Unit Test", function () {
    test("create a entity order with from", function () {
        $order = Order::from([
            'customer' => Customer::from(name: 'testing'),
            'items' => [],
            'status' => Status::PENDING,
        ]);

        assertInstanceOf(Data::class, $order);
        assertInstanceOf(Customer::class, $order->customer);
    });

    test("create a entity order with from and items", function () {
        $order = Order::from([
            'customer' => Customer::from(name: 'testing'),
            'items' => [
                Item::from(name: 'testing 01'),
                Item::from(name: 'testing 02'),
                Item::from(name: 'testing 03'),
            ],
            'status' => Status::PENDING,
        ]);

        assertInstanceOf(Data::class, $order);
        assertInstanceOf(Customer::class, $order->customer);
    });
});