<?php

declare(strict_types=1);

use Tests\Events\Transaction\CreateEvent;
use Tests\Events\Transaction\UpdateEvent;
use Tests\Stubs\TransactionStub;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;

describe("TransactionStub Unit Test", function () {
    test("creating a new transaction", function () {
        $transaction = new TransactionStub(value: 50);
        assertCount(1, $transaction->getEvents());
        assertInstanceOf(CreateEvent::class, $transaction->getEvents()[0]);
    });

    test("making a transaction", function () {
        $transaction = TransactionStub::make(value: 50);
        assertCount(0, $transaction->getEvents());
    });

    test("making a transaction and change value", function () {
        $transaction = TransactionStub::make(value: 50);
        $transaction->changeValue(100);
        assertCount(1, $transaction->getEvents());
        assertInstanceOf(UpdateEvent::class, $transaction->getEvents()[0]);
    });
});