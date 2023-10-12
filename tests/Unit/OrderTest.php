<?php

declare(strict_types=1);

use Costa\Entity\Data;
use Stubs\Customer;
use Stubs\Order;

use function PHPUnit\Framework\assertInstanceOf;

describe("Order Unit Test", function(){
    test("create a entity order with from", function(){
        $order = Order::from(
            customer: [
                'name' => 'bruno costa'
            ],
            items: [],
        );

        assertInstanceOf(Data::class, $order);
        assertInstanceOf(Customer::class, $order->customer);
    });
});