<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsuredContract extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['content', 'finish_content', 'status', 'meta', 'insured_id', 'contract_id', 'status', 'owner_signed', 'signed_at'];

    protected $casts = ['id' => 'string', 'created_at' => 'date:m-d-Y', 'signed_at' => 'date:m-d-Y'];

    public function insured()
    {
        return $this->belongsTo(Insured::class, 'insured_id', 'id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function insuredResources()
    {
        return $this->hasMany(InsuredContractResource::class, 'insured_contract_id', 'id');
    }

    public function insuredSignature()
    {
        return $this->hasOne(InsuredContractSignature::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
