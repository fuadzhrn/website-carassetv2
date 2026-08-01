<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\AdminLoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    private const GENERIC_ERROR = 'Kredensial tidak valid atau akun tidak dapat digunakan.';

    /**
     * Show the admin login page.
     *
     * Already-authenticated users never reach this method — the `guest`
     * middleware on this route redirects them to admin.dashboard first
     * (see bootstrap/app.php redirectUsersTo).
     */
    public function create(): \Illuminate\View\View
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an admin login attempt.
     */
    public function store(AdminLoginRequest $request): RedirectResponse
    {
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'login' => 'Terlalu banyak percobaan login. Silakan coba kembali beberapa saat lagi.',
            ]);
        }

        $field = $request->loginIsEmail() ? 'email' : 'username';

        $credentials = [
            $field => $request->validated('login'),
            'password' => $request->validated('password'),
        ];

        if (! Auth::attempt($credentials, false)) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'login' => self::GENERIC_ERROR,
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        if (! $user->isAdmin() || ! $user->isActive()) {
            Auth::logout();
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'login' => self::GENERIC_ERROR,
            ]);
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        $user->forceFill(['last_login_at' => now()])->save();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Log the admin out.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('status', 'Anda telah keluar dari panel admin.');
    }

    /**
     * Build a rate limiter key from the normalized login and the request IP.
     */
    private function throttleKey(Request $request): string
    {
        return Str::lower($request->input('login')).'|'.$request->ip();
    }
}
