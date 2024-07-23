<?php

declare(strict_types=1);

namespace App\Models\Concerns;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
