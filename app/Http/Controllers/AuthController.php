<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Http\Requests\Auth\ApiChangePasswordRequest;
use App\Http\Requests\Auth\ApiLoginRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AuthController extends Controller
{
    use RespondsWithJson;

    public function __construct(protected AuthService $authService)
    {
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function loginWithGoogle(Request $request): RedirectResponse
    {
        $credential = $request->validate([
            'credential' => ['required', 'string'],
        ])['credential'];

        try {
            $response = Http::acceptJson()
                ->timeout(10)
                ->get('https://oauth2.googleapis.com/tokeninfo', [
                    'id_token' => $credential,
                ]);
        } catch (\Throwable $exception) {
            return back()->with('error', 'Google tidak dapat dihubungi. Silakan coba lagi.');
        }

        $googleUser = $response->json();
        $validIssuer = in_array($googleUser['iss'] ?? null, [
            'accounts.google.com',
            'https://accounts.google.com',
        ], true);

        if (
            ! $response->successful()
            || ($googleUser['aud'] ?? null) !== config('services.google.client_id')
            || ! $validIssuer
            || ! in_array($googleUser['email_verified'] ?? null, [true, 'true', 1, '1'], true)
            || (int) ($googleUser['exp'] ?? 0) <= now()->timestamp
            || empty($googleUser['sub'])
            || empty($googleUser['email'])
        ) {
            return back()->with('error', 'Identitas Google tidak valid atau sudah kedaluwarsa.');
        }

        $user = $this->authService->findOrCreateGoogleUser([
            'id' => $googleUser['sub'],
            'name' => $googleUser['name'] ?? $googleUser['email'],
            'email' => $googleUser['email'],
            'avatar' => $googleUser['picture'] ?? null,
        ]);

        $this->authService->login($user, $request);

        return $this->redirectAfterLogin($request);
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $this->authService->registerGuardian($validated);
        $this->authService->login($user, $request);

        return redirect()->route('parent.portal')
            ->with('success', 'Akun berhasil dibuat. Sekarang Anda bisa lanjut isi formulir PPDB.');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $remember = $request->boolean('remember');

        if (! $this->authService->attemptWeb($credentials, $remember)) {
            return back()
                ->withErrors([
                    'email' => 'Email atau password tidak valid.',
                ])
                ->onlyInput('email');
        }

        return $this->redirectAfterLogin($request);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return redirect()->route('home')->with('success', 'Anda berhasil logout.');
    }

    protected function redirectAfterLogin(Request $request): RedirectResponse
    {
        $user = $request->user();

        return redirect()->intended(route($this->authService->redirectRouteFor($user)));
    }

    // API Methods
    public function apiLogin(ApiLoginRequest $request): JsonResponse
    {
        $user = $this->authService->attemptApi($request->validated());
        $token = $this->authService->createApiToken($user);

        return $this->successJson('Login berhasil', [
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function apiLogout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();

        return $this->successJson('Logout berhasil');
    }

    public function apiChangePassword(ApiChangePasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->authService->changePassword(
            $request->user(),
            $validated['current_password'],
            $validated['new_password']
        );

        return $this->successJson('Password berhasil diubah');
    }

    public function apiProfile(Request $request): JsonResponse
    {
        return $this->successJson('Data profil berhasil diambil', $request->user());
    }

}
