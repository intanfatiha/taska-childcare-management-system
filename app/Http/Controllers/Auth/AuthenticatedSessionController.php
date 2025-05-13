<?php

namespace App\Http\Controllers\Auth;
use App\Models\LoginHistory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

         // Log the login details
        LoginHistory::create([
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'login_time' => now(),
        ]);

        return redirect()->intended(route('adminHomepage', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
       // Update the logout time for the user's most recent login history
        LoginHistory::where('user_id', Auth::id())
            ->latest('login_time')
            ->first()
            ->update(['logout_time' => now()]);

        Auth::guard('web')->logout();

         


        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
