<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['subject', 'message', 'internal_notes', 'invoice_number', 'insured_contract_id'];

    protected $casts = ['id' => 'string'];

    public function invoiceResources()
    {
        return $this->hasMany(InvoiceResource::class);
    }

    public function invoiceFees()
    {
        return $this->hasMany(InvoiceFee::class);
    }

    public function insuredContract()
    {
        return $this->belongsTo(InsuredContract::class);
    }

    public function multimedia()
    {
        return $this->morphMany(Multimedia::class, 'publishable');
    }
}
