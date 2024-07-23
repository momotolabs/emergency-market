<?php

namespace App\Models;

use App\Models\Concerns\UserTypes;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Auth\Passwords\CanResetPassword as ResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword, HasName, FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use ResetPassword;
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['email', 'password', 'type', 'status', 'first_time'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
        'first_time' => 'boolean',
    ];

    public function providerProfile(): HasOne
    {
        return $this->hasOne(ProviderProfile::class);
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }

    public function getFilamentName(): string
    {
        return $this->email;
    }

    public function canAccessFilament(): bool
    {
        return $this->type === UserTypes::ADMIN->value;
    }
}
