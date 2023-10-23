<?php

declare(strict_types=1);

namespace Tests\Events\Customer;

use Costa\Entity\Contracts\EventInterface;
use Tests\Stubs\CustomerStub;

class ChangeNameEvent implements EventInterface
{
    public function __construct(protected CustomerStub $customer)
    {
    }

    public function payload(): array
    {
        return $this->customer->toArray();
    }
}