<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Support\NotificationSupport;

trait ValidateTrait
{
    public abstract function toArray();

    protected abstract function notification(): NotificationSupport;

    protected abstract function rules(): array;

    protected abstract function validated(): void;

}