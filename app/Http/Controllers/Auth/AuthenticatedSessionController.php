<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
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
        if(!@env('RECAPTCHA_DISABLED')){
           // CAPTCHA VALIDATION
            $request->validate([
                'g-recaptcha-response' => 'required|captcha'
            ], [
                'g-recaptcha-response' => [
                    'required' => 'Please verify that you are not a robot.',
                    'captcha' => 'Captcha error! try again later or contact site admin.',
                ],
            ]); 
        }

        $request->authenticate();

        // INACTIVE
        if(!@\Auth::user()->active){
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('login')->withErrors(['email' => 'Your account was inactive, please contact administrator']);
        }

        $request->session()->regenerate();

        $token = $request->user()->createToken($request->email);
        session(['secret' => ['token' => $token->plainTextToken,'token_id' => $token->accessToken->id]]);

        return redirect()->intended(homeRedirect());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
