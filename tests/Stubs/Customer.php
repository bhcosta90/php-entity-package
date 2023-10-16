<?php

declare(strict_types=1);

namespace Stubs;

use Costa\Entity\Data;
use Costa\Entity\Exceptions\NotificationException;

class Customer extends Data
{
    /**
     * @throws NotificationException
     */
    public function __construct(
        protected string $name,
    ) {
        parent::__construct();
        $this->validated();
    }


    protected function rules(): array
    {
        return [
            'name' => 'required|min:3',
        ];
    }
}