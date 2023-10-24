<?php

declare(strict_types=1);

use Costa\Entity\Contracts\DataInterface;
use Costa\Entity\Contracts\EventInterface;
use Costa\Entity\Exceptions\NotificationException;
use Costa\Entity\Exceptions\PropertyException;
use Costa\Entity\ValueObject\Uuid;
use Tests\Events\Customer\ChangeNameEvent;
use Tests\Stubs\AddressStub;
use Tests\Stubs\BusinessStub;
use Tests\Stubs\CustomerStub;

use Tests\Stubs\Enums\DocumentTypeEnum;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

describe("CustomerStub Unit Test", function () {
    test("Creating a new customer", function () {
        $customer = new CustomerStub(name: 'testing');
        assertInstanceOf(DataInterface::class, $customer);
    });

    test("Creating a customer with data", function () {
        $customer = CustomerStub::make(
            name: 'testing',
            id: $id = Uuid::make(),
            createdAt: $createdAt = new DateTime('2020-01-01 00:00:00'),
            updatedAt: $updatedAt = new DateTime('2020-01-02 00:00:00'),
        );
        assertInstanceOf(DataInterface::class, $customer);
        assertEquals($customer->id(), $id);
        assertEquals($customer->createdAt(), $createdAt->format('Y-m-d H:i:s'));
        assertEquals($customer->updatedAt(), $updatedAt->format('Y-m-d H:i:s'));
    });

    test("Creating a customer with array data", function () {
        $customer = CustomerStub::make([
            "name" => 'testing',
            "id" => (string)$id = Uuid::make(),
            "createdAt" => $createdAt = new DateTime('2020-01-01 00:00:00'),
            "updatedAt" => $updatedAt = new DateTime('2020-01-02 00:00:00'),
        ]);
        assertInstanceOf(DataInterface::class, $customer);
        assertEquals($customer->id(), $id);
        assertEquals($customer->createdAt(), $createdAt->format('Y-m-d H:i:s'));
        assertEquals($customer->updatedAt(), $updatedAt->format('Y-m-d H:i:s'));
    });

    test("Creating a customer and return toArray without address and order", function () {
        $customer = CustomerStub::make(
            name: 'testing',
            id: $id = Uuid::make(),
            createdAt: $createdAt = new DateTime('2020-01-01 00:00:00'),
            updatedAt: $updatedAt = new DateTime('2020-01-02 00:00:00'),
        );

        assertEquals([
            'id' => (string)$id,
            'business' => null,
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'name' => (string)'testing',
            'updated_at' => $updatedAt->format('Y-m-d H:i:s'),
            'address' => [],
            'orders' => [],
            'document_type_enum' => null,
            'document' => null,
        ], $customer->toArray());
    });

    test("Creating a customer and return toArray with addresses", function () {
        $address01 = new AddressStub(name: 'testing');
        $address02 = new AddressStub(name: 'testing');
        $address03 = new AddressStub(name: 'testing');

        $customer = CustomerStub::make(
            name: 'testing',
            id: $id = Uuid::make(),
            createdAt: $createdAt = new DateTime('2020-01-01 00:00:00'),
            updatedAt: $updatedAt = new DateTime('2020-01-02 00:00:00'),
            address: [$address01, $address02, $address03]
        );

        assertEquals([
            'id' => (string)$id,
            'business' => null,
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'name' => (string)'testing',
            'updated_at' => $updatedAt->format('Y-m-d H:i:s'),
            'address' => [$address01->toArray(), $address02->toArray(), $address03->toArray()],
            'orders' => [],
            'document_type_enum' => null,
            'document' => null,
        ], $customer->toArray());
    });

    test("Creating a customer and return toArray with orders", function () {
        $order01 = Uuid::make();
        $order02 = Uuid::make();
        $order03 = Uuid::make();

        $customer = CustomerStub::make(
            name: 'testing',
            id: $id = Uuid::make(),
            createdAt: $createdAt = new DateTime('2020-01-01 00:00:00'),
            updatedAt: $updatedAt = new DateTime('2020-01-02 00:00:00'),
            orders: [$order01, $order02, $order03]
        );

        assertEquals([
            'id' => (string)$id,
            'business' => null,
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'name' => (string)'testing',
            'updated_at' => $updatedAt->format('Y-m-d H:i:s'),
            'orders' => [(string)$order01, (string)$order02, (string)$order03],
            'address' => [],
            'document_type_enum' => null,
            'document' => null,
        ], $customer->toArray());
    });

    test("Creating a customer and return toArray with business", function () {
        $business = new BusinessStub(name: 'testing');

        $customer = CustomerStub::make(
            name: 'testing',
            id: $id = Uuid::make(),
            createdAt: $createdAt = new DateTime('2020-01-01 00:00:00'),
            updatedAt: $updatedAt = new DateTime('2020-01-02 00:00:00'),
            business: $business
        );

        assertEquals([
            'id' => (string)$id,
            'business' => $business->toArray(),
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'name' => (string)'testing',
            'updated_at' => $updatedAt->format('Y-m-d H:i:s'),
            'orders' => [],
            'address' => [],
            'document_type_enum' => null,
            'document' => null,
        ], $customer->toArray());
    });

    test("Exception name of customer", fn() => expect(fn() => new CustomerStub(name: 'a'))
        ->toThrow(NotificationException::class)
    );

    test("Creating a customer and get name", function () {
        $customer = new CustomerStub(name: 'testing');
        assertEquals($customer->name, 'testing');
    });

    test("Exception when get a property that do not exist", function () {
        $customer = new CustomerStub(name: 'testing');
        expect(fn() => $customer->email)->toThrow(PropertyException::class);
    });

    test("Creating a customer with document", function () {
        $customer = new CustomerStub(name: 'testing', documentTypeEnum: DocumentTypeEnum::PF, document: '99999999999');

        assertEquals([
            'id' => (string)$customer->id(),
            'business' => null,
            'created_at' => $customer->createdAt(),
            'name' => (string)'testing',
            'updated_at' => $customer->updatedAt(),
            'orders' => [],
            'address' => [],
            'document_type_enum' => 'cpf',
            'document' => '99999999999',
        ], $customer->toArray());
    });

    describe("Testing update a customer", function () {
        test("Change name", function () {
            $customer = new CustomerStub(name: 'testing');
            $customer->changeName('testing 2');

            assertEquals('testing 2', $customer->name);
        });

        test("Testing events of customer", function () {
            $customer = new CustomerStub(name: 'testing');
            $customer->changeName('testing 2');

            assertCount(1, $customer->getEvents());
            assertInstanceOf(ChangeNameEvent::class, $customer->getEvents()[0]);
            assertInstanceOf(EventInterface::class, $customer->getEvents()[0]);
        });

        test("exception when name is invalid", function () {
            $customer = new CustomerStub(name: 'testing');
            expect(fn() => $customer->changeName('t'))->toThrow(NotificationException::class);
        });
    });
});