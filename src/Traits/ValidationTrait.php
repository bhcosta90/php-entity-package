<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Validator\RakitValidation;
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