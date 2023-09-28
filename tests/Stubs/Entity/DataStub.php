<?php

declare(strict_types=1);

namespace Stubs\Entity;

use Costa\Entity\Data;

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

    protected function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:150',
            'email' => 'required|email|min:3',
        ];
    }

    protected function fillable(): array
    {
        return ['name'];
    }
}