<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['iso_code', 'name', 'slug'];

    protected $casts = ['id' => 'string'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function scopeOfCities($query, $state)
    {
        return $query->where('state_id', $state);
    }
}
