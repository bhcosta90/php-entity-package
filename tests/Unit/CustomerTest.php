<?php

declare(strict_types=1);

use Costa\Entity\Data;
use Costa\Entity\Exceptions\NotificationException;
use Costa\Entity\Exceptions\PropertyException;
use Costa\Entity\ValueObject\Uuid;
use Stubs\Customer;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotNull;

describe("Customer Unit Test", function () {
    test("verify all properties to entity", function () {
        $customer = Customer::from(name: 'testing');

        assertEquals('testing', $customer->name);
        assertNotNull($customer->id);
        assertNotNull($customer->createdAt);
        assertNotNull($customer->updatedAt);
    });

    test("exception when do not exist property", function () {
        $customer = Customer::from(name: 'testing');
        expect(fn() => $customer->email)->toThrow(PropertyException::class);
    });

    test("exception when name is invalid", function () {
        expect(fn() => Customer::from(name: 't'))->toThrow(NotificationException::class);
    });

    test("action from with setting parameter", function () {
        $customer = Customer::from(
            name: 'testing',
            id: new Uuid('5d0af754-68fd-11ee-8c99-0242ac120002'),
            createdAt: new DateTime('2020-01-01 00:00:00'),
            updatedAt: new DateTime('2020-01-02 00:00:00'),
        );

        assertInstanceOf(Data::class, $customer);
        assertEquals('testing', $customer->name);
        assertEquals('5d0af754-68fd-11ee-8c99-0242ac120002', (string)$customer->id);
        assertEquals('2020-01-01 00:00:00', $customer->createdAt->format('Y-m-d H:i:s'));
        assertEquals('2020-01-02 00:00:00', $customer->updatedAt->format('Y-m-d H:i:s'));
    });

    test("action from with array", function () {
        $customer = Customer::from([
            'name' => 'testing',
            'id' => new Uuid('5d0af754-68fd-11ee-8c99-0242ac120002'),
            'createdAt' => new DateTime('2020-01-01 00:00:00'),
            'updatedAt' => new DateTime('2020-01-02 00:00:00'),
        ]);

        assertInstanceOf(Data::class, $customer);
        assertEquals('testing', $customer->name);
        assertEquals('5d0af754-68fd-11ee-8c99-0242ac120002', (string)$customer->id);
        assertEquals('2020-01-01 00:00:00', $customer->createdAt->format('Y-m-d H:i:s'));
        assertEquals('2020-01-02 00:00:00', $customer->updatedAt->format('Y-m-d H:i:s'));
    });

    test("from action with parameters coming from the database", function () {
        $customer = Customer::from([
            'name' => 'testing',
            'id' => new Uuid('5d0af754-68fd-11ee-8c99-0242ac120002'),
            'created_at' => new DateTime('2020-01-01 00:00:00'),
            'updated_at' => new DateTime('2020-01-02 00:00:00'),
        ]);

        assertInstanceOf(Data::class, $customer);
        assertEquals('testing', $customer->name);
        assertEquals('5d0af754-68fd-11ee-8c99-0242ac120002', (string)$customer->id);
        assertEquals('2020-01-01 00:00:00', $customer->createdAt->format('Y-m-d H:i:s'));
        assertEquals('2020-01-02 00:00:00', $customer->updatedAt->format('Y-m-d H:i:s'));
    });
});