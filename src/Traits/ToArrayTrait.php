<?php

declare(strict_types=1);

namespace Costa\Entity\Traits;

use Costa\Entity\Exceptions\ValidationException;

trait ToArrayTrait
{
    use ParameterTrait;

    private array $removeProperties = ['__notification'];

    /**
     * @throws ValidationException
     */
    public function toArray(): array
    {
        $response = [];

        foreach ($this->getProperties() as $value) {
            $p = $value['name'];
            if (in_array($p, $this->removeProperties)) {
                continue;
            }

            $response[$p] = $this->{$p};
        }

        if (method_exists($this, 'validate')) {
            $this->validate($response);
        }

        return $response;
    }
}