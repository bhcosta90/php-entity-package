<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Data\Data;

class DataStub extends Data
{
    public function __construct(
        protected string $name,
        protected string $email,
        protected array $contacts,
        protected AddressStub $address,
        protected array $orders,
    ) {
        //
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:120',
            'email' => 'required|email|min:3|max:120',
        ];
    }
}