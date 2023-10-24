<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Costa\Entity\Data;
use Tests\Events\Transaction\CreateEvent;
use Tests\Events\Transaction\UpdateEvent;

class TransactionStub extends Data
{
    public function __construct(protected float $value)
    {
        parent::__construct();
        $this->addEvent(new CreateEvent($this));
    }

    public function changeValue(float $value)
    {
        $this->value = $value;
        $this->addEvent(new UpdateEvent($this));
    }
}