<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuredContractResource extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'units',
        'price_cents',
        'price_currency',
        'insured_contract_id',
        'pricing_resource_id',
    ];

    protected $casts = [
        'id' => 'string',
        'units' => 'int',
        'price_cents' => 'int',
        'insured_contract_id' => 'string',
        'pricing_resource_id' => 'string',
    ];

    public function pricingResources()
    {
        return $this->hasOne(PricingResource::class, 'id', 'pricing_resource_id');
    }
}
