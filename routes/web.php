<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

Route::view('/', 'landing')->name('home');

Route::get('/ppdb/daftar', [PPDBController::class, 'register'])->name('ppdb.register');
Route::post('/ppdb/daftar', [PPDBController::class, 'submit'])->name('ppdb.submit');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/dashboard', function () {
    return redirect()->route(request()->user()->redirectRoute());
})->middleware('auth');

Route::get('/portal-orangtua', [ParentPortalController::class, 'index'])->middleware('auth')->name('parent.portal');
Route::put('/portal-orangtua/profil', [ParentPortalController::class, 'updateProfile'])->middleware('auth')->name('parent.portal.profile.update');
Route::put('/portal-orangtua/password', [ParentPortalController::class, 'updatePassword'])->middleware('auth')->name('parent.portal.password.update');
Route::post('/portal-orangtua/ppdb/{ppdb}/documents', [PPDBController::class, 'uploadPortalDocument'])->middleware('auth')->name('parent.portal.ppdb.documents.store');
Route::delete('/portal-orangtua/ppdb/{ppdb}/documents/{documentType}', [PPDBController::class, 'destroyPortalDocument'])->middleware('auth')->name('parent.portal.ppdb.documents.destroy');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
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
    Route::post('payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
    Route::post('payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
});
