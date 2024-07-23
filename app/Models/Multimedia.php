<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Multimedia extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'publishable_type', 'publishable_id', 'type', 'path',
    ];

    protected $casts = ['id' => 'string'];

    // protected function path(): Attribute
    // {
    //     return Attribute::make(get: fn ($value, $attributes) => Storage::url($attributes['path']));
    // }
}
