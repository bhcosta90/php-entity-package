<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Entity\Data;

class Order extends Data
{
    public function __construct(
        public Customer $customer,

        /** @var Item[] */
        public array $items,
    ) {
        //
    }
}