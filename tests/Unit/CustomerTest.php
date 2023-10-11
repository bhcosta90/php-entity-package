<?php

declare(strict_types=1);

use Costa\Entity\Exceptions\PropertyException;
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

    test("exception when do not exist property", function(){
        $customer = new Customer(name: 'testing');

        expect(fn() => $customer->email)->toThrow(PropertyException::class);
    });
});