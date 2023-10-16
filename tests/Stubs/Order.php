<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Entity\Data;
use Stubs\Enum\Status;

class Order extends Data
{
    public function __construct(
        protected Customer $customer,

        /** @var Item[] */
        protected array $items,

        protected Status $status,
    ) {
        parent::__construct();
    }
}