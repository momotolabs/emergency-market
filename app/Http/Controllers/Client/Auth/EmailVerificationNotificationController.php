<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class EmailVerificationNotificationController extends Controller
{
    public function create()
    {
        return Inertia::render('Join/VerificationMessage');
    }

    public function sendLink()
    {
        return Inertia::render('Join/SendVerificationLink', [
            'status' => session('status'),
        ]);
    }

    public function sendLinkEmail(Request $request)
    {
        $user = User::where('email', '=', strtolower($request->email))->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => 'This email does not match with our record',
            ]);
        }

        if (! $user->status && $user->email_verified_at !== null) {
            throw ValidationException::withMessages([
                'email' => 'Your account is inactive',
            ]);
        }

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'Verification link sent!');
    }

    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
