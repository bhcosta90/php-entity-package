<?php

declare(strict_types=1);

use Costa\Entity\Interfaces\ValueObjectInterface;
use Stubs\Address;

use function PHPUnit\Framework\assertInstanceOf;

test("Address Unit Test", function(){
    $address = Address::from([
        'state' => '5044eaa6-6917-11ee-8c99-0242ac120002',
        'state_created_at' => '2020-01-01 00:00:00'
    ]);

    assertInstanceOf(ValueObjectInterface::class, $address->state);
});