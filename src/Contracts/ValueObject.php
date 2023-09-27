<?php

namespace Costa\Data\Contracts;

interface ValueObject
{
    public static function make(): self;

    public function __toString(): string;
}