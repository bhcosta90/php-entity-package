<?php

declare(strict_types=1);

namespace Tests\Stubs\Enums;

enum DocumentTypeEnum: string
{
    case PF = 'cpf';

    case PJ = 'cnpj';
}
