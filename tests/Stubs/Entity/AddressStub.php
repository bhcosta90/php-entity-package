<?php

declare(strict_types=1);

namespace Stubs\Entity;

use Costa\Entity\Data;

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

    protected function toArray(): array
    {
        return [];
    }
}