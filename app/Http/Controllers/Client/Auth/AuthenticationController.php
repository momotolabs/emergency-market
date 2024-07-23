<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AuthenticationController extends Controller
{
    public function index()
    {
        return Inertia::render(component: 'Login/Index');
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', Password::default()],
        ]);
    }
}
