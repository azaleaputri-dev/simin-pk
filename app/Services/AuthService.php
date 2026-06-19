<?php

namespace App\Services;

use App\Models\Guardian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function registerGuardian(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $guardian = Guardian::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'] ?? '-',
                'father_name' => $data['name'],
                'mother_name' => $data['name'],
            ]);

            $user->setRelation('guardian', $guardian);

            return $user;
        });
    }

    public function attemptWeb(array $credentials, bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    public function attemptApi(array $credentials): User
    {
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password tidak valid.'],
            ]);
        }

        return Auth::user()?->loadMissing('guardian');
    }

    public function login(User $user, Request $request): void
    {
        Auth::login($user);
        $request->session()->regenerate();
    }

    public function logout(Request $request): void
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function createApiToken(User $user, string $tokenName = 'auth-token'): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }

    public function changePassword(User $user, string $currentPassword, string $newPassword): void
    {
        if (! Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password saat ini tidak valid.'],
            ]);
        }

        $user->update([
            'password' => Hash::make($newPassword),
        ]);
    }

    public function redirectRouteFor(User $user): string
    {
        return $user->redirectRoute();
    }

    public function findOrCreateGoogleUser(array $googleUser): User
    {
        $existing = User::where('email', $googleUser['email'])->first();

        if ($existing) {
            if (!$existing->google_id) {
                $existing->update(['google_id' => $googleUser['id'], 'avatar' => $googleUser['avatar']]);
            }
            return $existing;
        }

        return DB::transaction(function () use ($googleUser) {
            $user = User::create([
                'name' => $googleUser['name'],
                'email' => $googleUser['email'],
                'google_id' => $googleUser['id'],
                'avatar' => $googleUser['avatar'],
                'password' => '',
            ]);

            Guardian::create([
                'user_id' => $user->id,
                'name' => $googleUser['name'],
                'email' => $googleUser['email'],
                'phone' => '-',
                'address' => '-',
                'father_name' => $googleUser['name'],
                'mother_name' => $googleUser['name'],
            ]);

            $user->setRelation('guardian', $user->guardian);

            return $user;
        });
    }
}
