<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricingResource extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'minimum_units',
        'price_cents',
        'taxable',
        'price_currency',
        'resource_id',
        'company_id',
    ];

    protected $casts = [
        'id' => 'string',
        'company_id' => 'string',
        'minimum_units' => 'int',
        'price_cents' => 'int',
        'taxable' => 'boolean',
        'resource_id' => 'string',
    ];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class)->withTrashed();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
