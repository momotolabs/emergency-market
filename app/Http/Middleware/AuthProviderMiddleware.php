<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Concerns\UserTypes;
use Closure;
use Illuminate\Http\Request;

class AuthProviderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->type !== UserTypes::PROVIDER->value) {
            abort(403, 'Only providers can access');
        }

        return $next($request);
    }
}
