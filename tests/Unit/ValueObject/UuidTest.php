<?php

use Costa\Entity\Contracts\ValueObjectInterface;
use Costa\Entity\ValueObject\Uuid;

describe("Uuid Unit Test", function () {
    test("give type of the class", function () {
        expect(Uuid::make())->toBeInstanceOf(ValueObjectInterface::class);
    });

    test("return a string uuid", function () {
        $uuid = Uuid::make();
        expect((string)$uuid)->toBeString()
            ->and(strlen($uuid))->toBe(36);
    });

    test("sending an invalid uuid", function () {
        expect(fn() => new Uuid('testing'))->toThrow(
            new InvalidArgumentException(
                sprintf(
                    '<%s> does not allow the value <%s>',
                    Uuid::class,
                    'testing'
                )
            )
        );
    });
});
