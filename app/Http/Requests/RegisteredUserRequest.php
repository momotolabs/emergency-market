<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisteredUserRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::default()],
            'provider_profile.first_name' => 'required|string|max:255',
            'provider_profile.last_name' => 'required|string|max:255',
            'company.name' => 'required|string|max:255',
        ];
    }
}
