<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Insured extends Model
{
    use HasFactory;
    use HasUuids;
    use PostgisTrait;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'address',
        'phone',
        'insurance_company',
        'claim_number',
        'email',
        'coordinates',
    ];

    protected $postgisFields = [
        'coordinates',
    ];

    protected $casts = ['id' => 'string'];
}
