<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisteredUserRequest;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Join/Index');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'email' => strtolower($request->email),
                    'password' => Hash::make($request->password),
                ]);

                $user->providerProfile()->create([
                    'first_name' => $request->provider_profile['first_name'],
                    'last_name' => $request->provider_profile['last_name'],
                ]);

                $slug = Str::slug($request->company['name']);

                $companyNameSlug = Company::query()->where('slug', '=', Str::slug($request->company['name']))->count();

                if ($companyNameSlug > 0) {
                    $companyNameSlugNew = $request->company['name'].'-'.Carbon::now()->timestamp;
                    $slug = Str::slug($companyNameSlugNew);
                }

                $user->company()->create([
                    'name' => $request->company['name'],
                    'slug' => $slug,
                ]);
                event(new Registered($user));
            });

            return to_route('join.index')->with('notification', ['type' => 'alert', 'message' => 'Successful']);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return back()->with('notification', [
                'type' => 'error',
                'message' => 'There was a problem processing the request', //'Please, check and complete the form',
            ]);
        }
    }
}
