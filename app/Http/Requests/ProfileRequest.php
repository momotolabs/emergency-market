<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'address' => ['nullable'],
            'state_id' => ['required'],
            'city_id' => ['required'],
            'description' => ['required'],
            'google_link' => ['nullable', ' url'],
            'kind' => ['required'],
            'miles' => ['required', 'integer', 'max:100'],
            'name' => ['required'],
            'parking_address' => ['nullable'],
            'parking_latitude' => ['nullable', 'numeric'],
            'parking_longitude' => ['nullable', 'numeric'],
            'phone' => ['required', 'min:10', 'numeric', 'numeric'],
            'state_id' => ['required'],
            'website_link' => ['nullable', 'url'],
            'youtube_link' => ['nullable', 'url'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            //
            'first_name' => ['required'],
            'last_name' => ['required'],
            'cellphone' => ['required', 'min:10', 'numeric', 'integer'],
        ];
    }
}
