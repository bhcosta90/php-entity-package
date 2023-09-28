<?php

declare(strict_types=1);

use Costa\Data\Builder\DataBuilder;
use Stubs\Entity\AddressStub;
use Stubs\Entity\DataStub;

use function PHPUnit\Framework\assertNotNull;

describe("DataBuilder Unit Test", function () {
    beforeEach(fn() => $this->entity = DataBuilder::make(DataStub::class, [
        'name' => 'testing',
        'email' => 'testin@test.com',
        'contacts' => [],
        'address' => new AddressStub(zipcode: '88888888'),
        'orders' => [],
    ]));

    test("verify id entity", function () {
        assertNotNull($this->entity->id);
    });

    test("verify created_at entity", function () {
        assertNotNull($this->entity->createdAt);
    });

    test("verify updated_at entity", function () {
        assertNotNull($this->entity->updatedAt);
    });
});