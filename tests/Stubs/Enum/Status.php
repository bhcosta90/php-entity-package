<?php

declare(strict_types=1);

namespace Stubs\Enum;

enum Status: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
}