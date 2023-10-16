<?php

declare(strict_types=1);

use Costa\Entity\Interfaces\ValueObjectInterface;
use Costa\Entity\ValueObject\Uuid;
use Stubs\Address;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotNull;

test("Address Unit Test", function () {
    $address = Address::from([
        'state' => new Uuid('5044eaa6-6917-11ee-8c99-0242ac120002'),
        'state_created_at' => new DateTime('2020-01-01 00:00:00'),
    ]);

    assertInstanceOf(ValueObjectInterface::class, $address->state);
    assertInstanceOf(DateTimeInterface::class, $address->stateCreatedAt);

    assertNotNull($address->id);
    assertNotNull($address->createdAt);
    assertNotNull($address->updatedAt);
});