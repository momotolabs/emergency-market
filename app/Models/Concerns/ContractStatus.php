<?php

declare(strict_types=1);

namespace App\Models\Concerns;

enum ContractStatus: string
{
    case VIEWED = 'viewed';
    case OPEN = 'open';
    case CLOSED = 'closed';
}