<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Entity\Data;

class Item extends Data
{
    public function __construct(
        protected string $name,
    ) {
        parent::__construct();
    }
}