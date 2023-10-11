<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Entity\Data;
use Costa\Entity\Traits\EntityTrait;

class Customer extends Data
{
    use EntityTrait;

    public function __construct(
        protected string $name,
    ) {
        //
    }
}