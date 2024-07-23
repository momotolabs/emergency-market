<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderProfile extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'user_id',
        'signature',
    ];

    protected $casts = ['id' => 'string', 'user_id' => 'string'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'user_id', 'user_id');
    }
}
