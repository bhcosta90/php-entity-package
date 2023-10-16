<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Entity\Data;
use Costa\Entity\ValueObject\Uuid;
use DateTime;

class Address extends Data
{
    protected Uuid $state;

    protected DateTime $stateCreatedAt;

    public function __construct()
    {
        parent::__construct();
    }
}