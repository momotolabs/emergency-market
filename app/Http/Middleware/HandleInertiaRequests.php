<?php

namespace App\Http\Middleware;

use App\Models\Concerns\UserTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        $ob = null;
        if (Auth::check() && Auth::user()->type !== UserTypes::ADMIN->value) {
            $user = $request->user()->load('providerProfile');
            $ob = [
                'user' => $user,
                'avatar' => $user->company?->getAvatar(),
            ];
        }

        return array_merge(parent::share($request), [
            'auth' => fn () => $ob,
            'notification' => fn () => $request->session()->get('notification'),
        ]);
    }
}
