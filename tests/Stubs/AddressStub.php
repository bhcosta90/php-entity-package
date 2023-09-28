<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Data\Data;

class AddressStub extends Data
{
    public function __construct(protected string $zipcode)
    {
    }

    public function rules(): array
    {
        return [
            'zipcode' => 'required'
        ];
    }
}