<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'content',
        'default',
        'company_id',
    ];

    protected $casts = [
        'id' => 'string',
        'company_id' => 'string',
        'default' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function pricingResources()
    {
        return $this->hasMany(PricingResource::class, 'company_id', 'id');
    }

    public function insuredContract()
    {
        return $this->hasMany(InsuredContract::class, 'contract_id', 'id');
    }

    public function scopeDefault($query)
    {
        $query->where('default', true);
    }
}
