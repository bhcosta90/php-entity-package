<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Costa\Entity\Data;

class BusinessStub extends Data
{
    public function __construct(protected string $name)
    {
        parent::__construct();
    }
}