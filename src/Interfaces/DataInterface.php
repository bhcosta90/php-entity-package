<?php

declare(strict_types=1);

namespace Costa\Entity\Interfaces;

interface DataInterface
{
    public static function from(mixed ...$payloads);
}