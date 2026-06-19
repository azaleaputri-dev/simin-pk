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

    public function googleLogin(Request $request): JsonResponse|RedirectResponse
    {
        $idToken = trim((string) $request->input('id_token'));

        if ($idToken === '') {
            return $this->googleError('ID token tidak ditemukan.');
        }

        $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $idToken,
        ]);

        if ($response->failed() || ! empty($response->json('error_description'))) {
            return $this->googleError('Token Google tidak valid atau gagal diverifikasi.');
        }

        $payload = $response->json();

        $clientId = config('services.google.client_id');
        $audience = trim((string) ($payload['aud'] ?? ''));
        $authorizedParty = trim((string) ($payload['azp'] ?? ''));

        if (! in_array($clientId, [$audience, $authorizedParty], true)) {
            return $this->googleError('Client Google tidak cocok.');
        }

        $email = strtolower(trim((string) ($payload['email'] ?? '')));
        if ($email === '') {
            return $this->googleError('Email Google tidak ditemukan.');
        }

        $user = $this->authService->findOrCreateGoogleUser([
            'id' => (string) ($payload['sub'] ?? ''),
            'name' => (string) ($payload['name'] ?? ''),
            'email' => $email,
            'avatar' => (string) ($payload['picture'] ?? ''),
        ]);

        $this->authService->login($user, $request);

        if ($request->wantsJson()) {
            return $this->successJson('Login Google berhasil', [
                'user' => $user,
                'redirect' => route($this->authService->redirectRouteFor($user)),
            ]);
        }

        return $this->redirectAfterLogin($request);
    }

    protected function googleError(string $message): RedirectResponse
    {
        return redirect()->route('login')
            ->with('error', $message . ' Silakan coba lagi.');
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
