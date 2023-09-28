<?php

use Carbon\Carbon;
use Costa\Data\Exceptions\ValidationException;
use Costa\Data\ValueObject\Uuid;
use Stubs\AddressStub;
use Stubs\DataStub;
use Stubs\OrderStub;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;

beforeEach(function () {
    $this->address = new AddressStub();
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

        test("to array", function () {
            $data = $this->data->toArray();

            expect($data['contacts'])->toBe($this->contacts)
                ->and($data['orders'])->toBe([
                    $this->orders[0]->toArray(),
                    $this->orders[1]->toArray(),
                    $this->orders[2]->toArray(),
                ]);
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
                $entity->toArray();
            } catch (ValidationException $e) {
                assertEquals([
                    'The Name minimum is 3',
                    'The Email is not valid email',
                    'The Email minimum is 3',
                ], $e->errors());
            }
        });
    });

    describe("Setting a data", function () {
        test("a", function () {
            $entity = DataStub::from([
                'name' => 'testing',
                'email' => 'test@test.com',
                'id' => '586ea122-f366-4a0f-ad7b-3083c6383f82',
                'created_at' => '2000-01-01',
                'updated_at' => '2000-01-02',
                'contacts' => ['a', 'b'],
                'address' => new AddressStub(),
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
});