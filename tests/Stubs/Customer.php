<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Entity\Data;

class Customer extends Data
{
    public function __construct(
        protected string $name,
    ) {
        //
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|min:3'
        ];
    }
}