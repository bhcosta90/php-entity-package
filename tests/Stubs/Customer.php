<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Entity\Data;
use Costa\Entity\Exceptions\NotificationException;

class Customer extends Data
{
    protected string $name;

    protected function rules(): array
    {
        return [
            'name' => 'required|min:3',
        ];
    }
}