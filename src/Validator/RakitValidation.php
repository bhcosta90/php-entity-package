<?php

declare(strict_types=1);

namespace Costa\Entity\Validator;

use Rakit\Validation\Validator;

class RakitValidation
{
    public static function validate($data, $rules): array
    {
        $errors = [];
        $validation = (new Validator())->validate($data, $rules);

        if ($validation->fails()) {
            foreach ($validation->errors()->all() as $error) {
                $errors[] = $error;
            }
        }

        return $errors;
    }
}