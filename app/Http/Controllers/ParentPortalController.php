<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParentPortal\UpdatePasswordRequest;
use App\Http\Requests\ParentPortal\UpdateProfileRequest;
use App\Services\ParentPortalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ParentPortalController extends Controller
{
    public function __construct(protected ParentPortalService $portalService)
    {
    }

    public function index()
    {
        $portalData = $this->portalService->buildFor(auth()->user());

        if (! $portalData) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun ini tidak terhubung ke portal orang tua.');
        }

        return view('parent.portal', $portalData);
    }

    public function profile(): View|RedirectResponse
    {
        $portalData = $this->portalService->buildFor(auth()->user());

        if (! $portalData) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun ini tidak terhubung ke portal orang tua.');
        }

        return view('parent.profile', $portalData);
    }

    public function ppdbHistory(): View|RedirectResponse
    {
        $portalData = $this->portalService->buildFor(auth()->user());

        if (! $portalData) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun ini tidak terhubung ke portal orang tua.');
        }

        return view('parent.ppdb-history', $portalData);
    }

    public function password(): View|RedirectResponse
    {
        $portalData = $this->portalService->buildFor(auth()->user());

        if (! $portalData) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun ini tidak terhubung ke portal orang tua.');
        }

        return view('parent.password', $portalData);
    }

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $guardian = $this->portalService->requireGuardianForUser($user);
        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $guardian->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('parent.portal.profile')->with('success', 'Profil akun berhasil diperbarui.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = $request->user();
        $this->portalService->requireGuardianForUser($user);
        $validated = $request->validated();

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini tidak valid.'])
                ->withInput($request->except(['current_password', 'password', 'password_confirmation']));
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('parent.portal.password')->with('success', 'Password akun berhasil diperbarui.');
    }
}
