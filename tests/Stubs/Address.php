<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Entity\Data;
use Costa\Entity\ValueObject\Uuid;
use DateTime;

class Address extends Data
{
    public function __construct(
        protected Uuid $state,
        protected DateTime $stateCreatedAt,
    ) {
        parent::__construct();
    }
}