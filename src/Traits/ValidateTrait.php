<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Exceptions\NotificationException;
use Costa\Entity\Factory\ValidatorFactory;
use Costa\Entity\Support\NotificationSupport;

trait ValidateTrait
{
    public abstract function toArray();

    protected abstract function notification(): NotificationSupport;

    protected abstract function rules(): array;

    protected abstract function validated(): void;

}