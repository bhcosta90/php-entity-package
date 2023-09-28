<?php

declare(strict_types=1);

namespace Stubs\Entity;

use Costa\Data\Data;

class DataStub extends Data
{
    public function __construct(
        protected string $name,
        protected string $email,
        protected array $contacts,
        protected AddressStub $address,
        protected array $orders,
    ) {
        //
    }
}