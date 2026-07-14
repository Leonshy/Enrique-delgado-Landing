<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HcaptchaHelper;
use App\Helpers\SettingsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const DECAY_MINUTES = 10;

    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) return redirect()->route('admin.dashboard');

        return view('admin.login', [
            'hcaptchaEnabled' => HcaptchaHelper::isEnabledFor('login'),
            'hcaptchaSiteKey' => SettingsHelper::get('hcaptcha_site_key', ''),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $rules = [
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ];

        if (HcaptchaHelper::isEnabledFor('login')) {
            $rules['h-captcha-response'] = ['required'];
        }

        $request->validate($rules, [
            'h-captcha-response.required' => 'Por favor completá el captcha.',
        ]);

        if (HcaptchaHelper::isEnabledFor('login')) {
            $result = HcaptchaHelper::verify(
                SettingsHelper::get('hcaptcha_secret_key', ''),
                (string) $request->input('h-captcha-response', ''),
                $request->ip()
            );

            if (!$result['ok']) {
                throw ValidationException::withMessages([
                    'h-captcha-response' => HcaptchaHelper::errorMessages($result['errors']),
                ]);
            }
        }

        $credentials = $request->only('email', 'password');
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Demasiados intentos. Probá de nuevo en " . ceil($seconds / 60) . " minuto(s).",
            ]);
        }

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey, self::DECAY_MINUTES * 60);

            throw ValidationException::withMessages([
                'email' => 'Las credenciales no son correctas.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();
        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    private function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email', '')) . '|' . $request->ip();
    }
}
