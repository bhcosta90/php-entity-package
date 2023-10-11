<?php

declare(strict_types=1);

use Stubs\Customer;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

describe("Customer Unit Test", function () {
    test("verify all properties to entity", function () {
        $customer = new Customer(name: 'testing');

        assertEquals('testing', $customer->name);
        assertNotNull($customer->id);
        assertNotNull($customer->createdAt);
        assertNotNull($customer->updatedAt);
    });
});