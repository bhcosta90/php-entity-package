<?php

use Stubs\MethodMagicsStub;

describe("Method Magics Unit Test", function () {
    beforeEach(fn() => $this->data = new MethodMagicsStub());

    test("exception trait", function () {
        expect(fn() => $this->data->name)->toThrow(
            new Exception('Property name not found in class ' . MethodMagicsStub::class)
        );
    });
});