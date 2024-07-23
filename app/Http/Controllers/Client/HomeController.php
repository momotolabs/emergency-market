<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\State;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Index');
    }

    public function welcome()
    {
        return Inertia::render('Welcome');
    }

    public function test()
    {
        return Inertia::render('TestComponents');
    }

    public function termOfService()
    {
        return inertia::render('TermOfService');
    }

    public function privacyPolicy()
    {
        return Inertia::render('PrivacyPolicy');
    }

    public function cities(State $state)
    {
        return $state->city()->get(['id', 'name']);
    }
}
