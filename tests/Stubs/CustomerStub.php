<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Costa\Entity\Data;
use Costa\Entity\Exceptions\NotificationException;
use Costa\Entity\ValueObject\Uuid;
use Tests\Events\Customer\ChangeNameEvent;

class CustomerStub extends Data
{
    public function __construct(
        protected string $name,
        protected ?BusinessStub $business = null,
        /**
         * @var AddressStub[]
         */
        protected array $address = [],
        /**
         * @var Uuid
         */
        protected array $orders = [],
    ) {
        parent::__construct();
    }


    protected function rules(): array
    {
        return [
            'name' => 'required|min:3|max:100',
        ];
    }

    /**
     * @throws NotificationException
     */
    public function changeName(string $name): self
    {
        if ($name != $this->name) {
            $this->name = $name;
            $this->add(new ChangeNameEvent($this));
            $this->validated();
        }

        return $this;
    }
}