<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParentPortal\UpdatePasswordRequest;
use App\Http\Requests\ParentPortal\UpdateProfileRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\ProfilSekolah;
use App\Services\ParentPortalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function invoices(): View|RedirectResponse
    {
        $portalData = $this->portalService->buildFor(auth()->user());

        if (! $portalData) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun ini tidak terhubung ke portal orang tua.');
        }

        return view('parent.invoices', $portalData);
    }

    public function invoiceDetail(Invoice $invoice): View|RedirectResponse
    {
        $user = auth()->user();
        $guardian = $this->portalService->guardianForUser($user);

        if (! $guardian || $invoice->parent_id !== $guardian->id) {
            return redirect()->route('parent.portal.invoices')
                ->with('error', 'Invoice tidak ditemukan.');
        }

        $invoice->load(['items', 'payments', 'student']);

        return view('parent.invoice-detail', [
            'invoice' => $invoice,
            'guardian' => $guardian,
            'schoolProfile' => ProfilSekolah::first(),
        ]);
    }

    public function submitPayment(Request $request, Invoice $invoice): RedirectResponse
    {
        $user = auth()->user();
        $guardian = $this->portalService->guardianForUser($user);

        if (! $guardian || $invoice->parent_id !== $guardian->id) {
            return redirect()->route('parent.portal.invoices')
                ->with('error', 'Invoice tidak ditemukan.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $invoice->remaining_amount,
            'sender_name' => 'required|string|max:100',
            'proof_reference' => 'nullable|string|max:100',
            'payment_date' => 'required|date',
        ]);

        Payment::create([
            'invoice_id' => $invoice->id,
            'payment_number' => Payment::generateNumber(),
            'payment_date' => $validated['payment_date'],
            'amount' => $validated['amount'],
            'payment_method' => Payment::METHOD_TRANSFER_BANK,
            'sender_name' => $validated['sender_name'],
            'proof_reference' => $validated['proof_reference'],
            'status' => Payment::STATUS_PENDING,
        ]);

        return redirect()->route('parent.portal.payments')
            ->with('success', 'Pembayaran berhasil dikirim dan menunggu verifikasi admin.');
    }

    public function payments(): View|RedirectResponse
    {
        $portalData = $this->portalService->buildFor(auth()->user());

        if (! $portalData) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun ini tidak terhubung ke portal orang tua.');
        }

        return view('parent.payments', $portalData);
    }

    public function paymentReceipt(Payment $payment): View|RedirectResponse
    {
        $user = auth()->user();
        $guardian = $this->portalService->guardianForUser($user);
        $invoice = $payment->invoice;

        if (! $guardian || ! $invoice || $invoice->parent_id !== $guardian->id) {
            return redirect()->route('parent.portal.payments')
                ->with('error', 'Pembayaran tidak ditemukan.');
        }

        $payment->load('invoice.student');

        return view('parent.payment-receipt', [
            'payment' => $payment,
            'schoolProfile' => ProfilSekolah::first(),
        ]);
    }

    public function children(): View|RedirectResponse
    {
        $portalData = $this->portalService->buildFor(auth()->user());

        if (! $portalData) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun ini tidak terhubung ke portal orang tua.');
        }

        return view('parent.children', $portalData);
    }

    public function announcements(): View|RedirectResponse
    {
        $portalData = $this->portalService->buildFor(auth()->user());

        if (! $portalData) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun ini tidak terhubung ke portal orang tua.');
        }

        return view('parent.announcements', $portalData);
    }

    public function contact(): View|RedirectResponse
    {
        $portalData = $this->portalService->buildFor(auth()->user());

        if (! $portalData) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun ini tidak terhubung ke portal orang tua.');
        }

        return view('parent.contact', $portalData);
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        \App\Models\AuditLog::create([
            'action' => 'contact_message',
            'entity_type' => 'guardian',
            'entity_id' => auth()->user()->guardian?->id,
            'description' => 'Pesan dari ' . $validated['name'] . ' (' . $validated['email'] . '): ' . $validated['subject'] . ' - ' . $validated['message'],
        ]);

        return redirect()->route('parent.portal.contact')
            ->with('success', 'Pesan berhasil dikirim. Admin akan merespon melalui email atau telepon.');
    }

    public function submitCorrection(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $guardian = $this->portalService->requireGuardianForUser($user);

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'field' => 'required|string|max:50',
            'current_value' => 'required|string|max:255',
            'proposed_value' => 'required|string|max:255',
            'reason' => 'required|string|max:1000',
        ]);

        \App\Models\AuditLog::create([
            'action' => 'correction_request',
            'entity_type' => 'student',
            'entity_id' => $validated['student_id'],
            'description' => 'Parent ' . $guardian->name . ' mengajukan perubahan ' . $validated['field'] . ' dari "' . $validated['current_value'] . '" menjadi "' . $validated['proposed_value'] . '". Alasan: ' . $validated['reason'],
        ]);

        return redirect()->route('parent.portal')
            ->with('success', 'Permintaan perbaikan data berhasil dikirim dan akan ditinjau admin.');
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
