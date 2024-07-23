<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceResource extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'invoice_id',
        'insured_contract_resource_id',
        'price_cents',
        'quantity',
        'description',
    ];

    protected $casts = ['id' => 'string'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function insuredContractResource()
    {
        return $this->belongsTo(InsuredContractResource::class);
    }
}
