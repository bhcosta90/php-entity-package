<?php

describe("Address Unit Test", function () {
    test("testing name", function () {
        $address = new \Tests\Stubs\AddressStub('testing');
        expect($address->name)->toBe("address-testing");
    });

    test("testing name with toArray", function () {
        $address = new \Tests\Stubs\AddressStub('testing');
        expect($address->toArray()['name'])->toBe("address-testing");
    });
});