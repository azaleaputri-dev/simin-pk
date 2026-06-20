<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\PPDBController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FeeTypeController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ParentPortalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home');

Route::get('/ppdb/daftar', [PPDBController::class, 'register'])->name('ppdb.register');
Route::post('/ppdb/daftar', [PPDBController::class, 'submit'])->name('ppdb.submit');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/auth/google', [AuthController::class, 'googleLogin'])->name('auth.google');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/dashboard', function () {
    return redirect()->route(request()->user()->redirectRoute());
})->middleware('auth');

Route::middleware('auth')->prefix('portal-orangtua')->group(function () {
    Route::get('/', [ParentPortalController::class, 'index'])->name('parent.portal');
    Route::get('/riwayat-ppdb', [ParentPortalController::class, 'ppdbHistory'])->name('parent.portal.ppdb.history');
    Route::get('/profil', [ParentPortalController::class, 'profile'])->name('parent.portal.profile');
    Route::put('/profil', [ParentPortalController::class, 'updateProfile'])->name('parent.portal.profile.update');
    Route::get('/password', [ParentPortalController::class, 'password'])->name('parent.portal.password');
    Route::put('/password', [ParentPortalController::class, 'updatePassword'])->name('parent.portal.password.update');
    Route::get('/tagihan', [ParentPortalController::class, 'invoices'])->name('parent.portal.invoices');
    Route::get('/tagihan/{invoice}', [ParentPortalController::class, 'invoiceDetail'])->name('parent.portal.invoices.detail');
    Route::post('/tagihan/{invoice}/bayar', [ParentPortalController::class, 'submitPayment'])->name('parent.portal.invoices.pay');
    Route::get('/pembayaran', [ParentPortalController::class, 'payments'])->name('parent.portal.payments');
    Route::get('/pembayaran/{payment}/nota', [ParentPortalController::class, 'paymentReceipt'])->name('parent.portal.payments.receipt');
    Route::get('/data-anak', [ParentPortalController::class, 'children'])->name('parent.portal.children');
    Route::get('/pengumuman', [ParentPortalController::class, 'announcements'])->name('parent.portal.announcements');
    Route::get('/kontak', [ParentPortalController::class, 'contact'])->name('parent.portal.contact');
    Route::post('/kontak', [ParentPortalController::class, 'submitContact'])->name('parent.portal.contact.submit');
    Route::post('/perbaikan-data', [ParentPortalController::class, 'submitCorrection'])->name('parent.portal.correction');
    Route::post('/ppdb/{ppdb}/documents', [PPDBController::class, 'uploadPortalDocument'])->name('parent.portal.ppdb.documents.store');
    Route::delete('/ppdb/{ppdb}/documents/{documentType}', [PPDBController::class, 'destroyPortalDocument'])->name('parent.portal.ppdb.documents.destroy');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/dashboard/ppdb-toggle', [DashboardController::class, 'togglePpdb'])->name('admin.ppdb.toggle');
    Route::post('/dashboard/ppdb-period', [DashboardController::class, 'updatePpdbPeriod'])->name('admin.ppdb.period');
    Route::resource('profil-sekolahs', ProfilSekolahController::class);
    Route::resource('ppdb', PPDBController::class)->except(['create', 'store']);
    Route::get('ppdb/create', [PPDBController::class, 'create'])->name('ppdb.create');
    Route::post('ppdb', [PPDBController::class, 'store'])->name('ppdb.store');
    Route::resource('academic-years', AcademicYearController::class);
    Route::resource('kelas', KelasController::class)->except(['show']);
    Route::resource('parents', ParentController::class)->except(['show']);
    Route::resource('students', StudentController::class)->except(['show']);
    Route::resource('fee-types', FeeTypeController::class)->except(['show']);
    Route::resource('tariffs', TariffController::class)->except(['show']);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('payments', PaymentController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('payments/{payment}/proof', [PaymentController::class, 'proof'])->name('payments.proof');
    Route::get('payments/{payment}/nota', [PaymentController::class, 'receipt'])->name('payments.receipt');
    Route::get('payments/{payment}/nota/print', [PaymentController::class, 'printReceipt'])->name('payments.receipt.print');
    Route::post('payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
    Route::post('payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
});
