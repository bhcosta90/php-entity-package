<?php

declare(strict_types=1);

namespace Costa\Entity;

use Costa\Entity\Traits\ToArrayTrait;
use Costa\Entity\Traits\ValidateTrait;

abstract class Data
{
    use ValidateTrait;
    use ToArrayTrait;
}