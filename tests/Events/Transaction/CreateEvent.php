<?php

declare(strict_types=1);

namespace Tests\Events\Transaction;

use Costa\Entity\Contracts\EventInterface;
use Tests\Stubs\TransactionStub;

class CreateEvent implements EventInterface
{
    public function __construct(protected TransactionStub $transactionStub)
    {
    }

    public function payload(): array
    {
        return [
            'id' => $this->transactionStub->id(),
        ];
    }

}