<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;

class Company extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    use PostgisTrait;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'kind',
        'state_id',
        'city_id',
        'address',
        'phone',
        'parking_address',
        'social',
        'meta',
        'description',
        'slug',
        'user_id',
        'address_coordinates',
        'parking_coordinates',
        'miles',
        'main_video',
    ];

    protected $postgisFields = [
        'address_coordinates',
        'parking_coordinates',
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'city_id' => 'string',
        'social' => 'json',
        'meta' => 'json',
        'kind' => 'string',
        'first_time' => 'boolean',
        //        'address_coordinates'=>'json',
        //        'parking_coordinates'=>'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function profileUser()
    {
        return $this->belongsTo(ProviderProfile::class, 'user_id', 'user_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function pricingResource()
    {
        return $this->hasMany(PricingResource::class);
    }

    public function multimedia()
    {
        return $this->morphMany(Multimedia::class, 'publishable');
    }

    public function getAvatar()
    {
        return $this?->multimedia()?->where('type', 'avatar')?->first();
    }

    public function getGallery()
    {
        return $this?->multimedia()?->where('type', 'gallery')->get();
    }

    public function getDefaultContract()
    {
        return $this->contracts()->with(['pricingResources'])->default()->first();
    }

    public function getContractUrl()
    {
        $state = strtolower($this->city->state->iso_code);

        return env('APP_URL')."/{$this->kind}/{$state}/{$this->city->slug}/{$this->slug}/contract";
    }
}
