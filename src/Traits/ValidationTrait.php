<?php

declare(strict_types=1);

namespace Costa\Data\Traits;

use Costa\Data\Validator\RakitValidation;
use Exception;

trait ValidationTrait
{
    public function rules(): array
    {
        return [];
    }

    /**
     * @throws Exception
     */
    public function validate($data): array
    {
        return RakitValidation::validate($data, $this->rules());
    }

    protected abstract function toArray(): array;
}