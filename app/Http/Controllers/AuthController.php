<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_SECONDS = 900;

    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectToRoleDashboard();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credential = strtolower(trim($request->input('email', '')));
        $throttleKey = 'login_' . ($credential ?: ($request->ip() ?? 'unknown'));

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => "Cuenta bloqueada temporalmente. Intenta de nuevo en {$seconds} segundos.",
            ]);
        }

        $validated = $request->validate([
            'email'    => 'required|string|min:3',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,recepcionista,cliente',
        ]);

        $user = User::where('email', $credential)
            ->orWhere('username', $credential)
            ->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            RateLimiter::hit($throttleKey, self::LOCKOUT_SECONDS);
            $remaining = self::MAX_ATTEMPTS - RateLimiter::attempts($throttleKey);

            return back()->withErrors([
                'email' => $remaining <= 0
                    ? 'Cuenta bloqueada por múltiples intentos fallidos. Espera 15 minutos.'
                    : 'Credenciales incorrectas. Te quedan ' . max(0, $remaining) . ' intentos.',
            ])->onlyInput('email');
        }

        if ($user->status !== 'activo') {
            RateLimiter::hit($throttleKey, self::LOCKOUT_SECONDS);
            return back()->withErrors([
                'email' => 'Tu cuenta está desactivada. Contacta al administrador.',
            ])->onlyInput('email');
        }

        if ($user->role !== $validated['role']) {
            RateLimiter::hit($throttleKey, self::LOCKOUT_SECONDS);
            $rolNombre = match ($validated['role']) {
                'admin'         => 'Administrador',
                'recepcionista' => 'Recepcionista',
                'cliente'       => 'Cliente',
            };
            return back()->withErrors([
                'role' => "No tienes permisos de acceso como {$rolNombre}. Selecciona el rol correcto.",
            ])->onlyInput('email', 'role');
        }

        RateLimiter::clear($throttleKey);

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectToRoleDashboard();
    }

    protected function redirectToRoleDashboard()
    {
        $user = Auth::user();

        $routeMap = [
            'admin'         => 'admin.dashboard',
            'recepcionista' => 'recepcionista.dashboard',
            'cliente'       => 'cliente.dashboard',
        ];

        $route = $routeMap[$user->role] ?? 'welcome';

        return redirect()->intended(route($route));
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectToRoleDashboard();
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username'  => 'required|string|max:50|unique:users|alpha_dash',
            'email'     => 'required|email:rfc,dns|max:100|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'first_name'=> 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone'     => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'username' => e($validated['username']),
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'cliente',
            'status'   => 'activo',
        ]);

        $user->client()->create([
            'first_name' => e($validated['first_name']),
            'last_name'  => e($validated['last_name']),
            'phone'      => $validated['phone'] ? e($validated['phone']) : null,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('cliente.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
