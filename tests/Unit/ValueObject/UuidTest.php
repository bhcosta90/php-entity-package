<?php

declare(strict_types=1);

use Costa\Entity\Interfaces\ValueObjectInterface;
use Costa\Entity\ValueObject\Uuid;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsString;

describe("Uuid Unit Test", function(){
    test("creating a new uuid", function(){
       $id = Uuid::make();
       assertInstanceOf(ValueObjectInterface::class, $id);
    });

    test("creating a uuid with value", function(){
        $id = new Uuid(value: '5cc2a07e-68fa-11ee-8c99-0242ac120002');
        assertInstanceOf(ValueObjectInterface::class, $id);
    });

    test("string uuid", function(){
        $id = Uuid::make();
        assertIsString((string) $id);
    });

    test("exception uuid", function(){
        expect(fn() => new Uuid(value: '123'))
            ->toThrow(InvalidArgumentException::class)
            ->toThrow(sprintf('<%s> does not allow the value <%s>', Uuid::class, '123'));
    });
});