<?php

use Carbon\Carbon;
use Costa\Data\Exceptions\ValidationException;
use Costa\Data\ValueObject\Uuid;
use Stubs\Entity\AddressStub;
use Stubs\Entity\DataStub;
use Stubs\Entity\OrderStub;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertNotNull;

beforeEach(function () {
    $this->address = new AddressStub(zipcode: '00000000');
    $this->orders = [
        new OrderStub(),
        new OrderStub(),
        new OrderStub(),
    ];
    $this->contacts = ['a', 'b'];
});

describe("Data Unit Test", function () {
    describe("Creating a new Data", function () {
        beforeEach(fn() => $this->data = new DataStub(
            name: 'testing',
            email: 'test@test.com',
            contacts: $this->contacts,
            address: $this->address,
            orders: $this->orders
        ));

        test("verify id entity", function () {
            assertNotNull($this->data->id);
        });

        test("verify created_at entity", function () {
            assertNotNull($this->data->createdAt);
        });

        test("verify updated_at entity", function () {
            assertNotNull($this->data->updatedAt);
        });

        test("create a new entity with from", function () {
            $entity = DataStub::from(
                name: 'testing 2',
                email: 'test2@email.com',
                contacts: $this->contacts,
                address: $this->address,
                orders: $this->orders,
            );

            assertNotNull($entity->id);
            assertNotNull($entity->createdAt);
            assertNotNull($entity->updatedAt);
        });

        test("validation name", function () {
            $entity = DataStub::from(
                name: 'a',
                email: 'b',
                contacts: $this->contacts,
                address: $this->address,
                orders: $this->orders,
            );

            try {
                assertFalse($entity->name);
            } catch (ValidationException $e) {
                assertEquals([
                    'Stubs\Entity\DataStub: The Name minimum is 3',
                    'Stubs\Entity\DataStub: The Email is not valid email',
                    'Stubs\Entity\DataStub: The Email minimum is 3',
                ], $e->errors());

                assertEquals(422, $e->status());
            }
        });
    });

    describe("Setting a data", function () {
        test("aaaaaaaaaaaaaa", function () {
            $entity = DataStub::from([
                'name' => 'testing',
                'email' => 'test@test.com',
                'id' => '586ea122-f366-4a0f-ad7b-3083c6383f82',
                'created_at' => '2000-01-01',
                'updated_at' => '2000-01-02',
                'contacts' => ['a', 'b'],
                'address' => new AddressStub(zipcode: '00000000'),
                'orders' => [new OrderStub(), new OrderStub()],
            ]);

            assertInstanceOf(Uuid::class, $entity->id);
            expect('586ea122-f366-4a0f-ad7b-3083c6383f82')->toBe((string)$entity->id);

            assertInstanceOf(Carbon::class, $entity->created_at);
            expect('2000-01-01')->toBe($entity->created_at->format('Y-m-d'));

            assertInstanceOf(Carbon::class, $entity->updated_at);
            expect('2000-01-02')->toBe($entity->updated_at->format('Y-m-d'));
        });
    });

    describe("Update a data", function(){
        beforeEach(fn() => $this->data = new DataStub(
            name: 'testing',
            email: 'test@test.com',
            contacts: $this->contacts,
            address: $this->address,
            orders: $this->orders
        ));

        test("update name", function(){
            $this->data->update(
                name: 'hahahah',
                email: 'test123@test.com',
            );

            assertEquals("hahahah", $this->data->name);
            assertNotEquals("test123@test.com", $this->data->email);
        });
    });
});