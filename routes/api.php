<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication API
Route::post('/login', [App\Http\Controllers\AuthController::class, 'apiLogin']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'apiLogout'])->middleware('auth:sanctum');
Route::post('/change-password', [App\Http\Controllers\AuthController::class, 'apiChangePassword'])->middleware('auth:sanctum');
Route::get('/profile', [App\Http\Controllers\AuthController::class, 'apiProfile'])->middleware('auth:sanctum');

// PPDB API
Route::post('/ppdb/register', [App\Http\Controllers\PPDBController::class, 'apiRegister']);
Route::post('/ppdb/submit', [App\Http\Controllers\PPDBController::class, 'apiSubmit'])->middleware('auth:sanctum');
Route::get('/ppdb/status', [App\Http\Controllers\PPDBController::class, 'apiStatus'])->middleware('auth:sanctum');
Route::post('/ppdb/upload-document', [App\Http\Controllers\PPDBController::class, 'apiUploadDocument'])->middleware('auth:sanctum');

// Student API
Route::get('/students', [App\Http\Controllers\StudentController::class, 'apiIndex'])->middleware('auth:sanctum');
Route::get('/students/{id}', [App\Http\Controllers\StudentController::class, 'apiShow'])->middleware('auth:sanctum');

// Invoice API
Route::get('/invoices', [App\Http\Controllers\InvoiceController::class, 'apiIndex'])->middleware('auth:sanctum');
Route::get('/invoices/{id}', [App\Http\Controllers\InvoiceController::class, 'apiShow'])->middleware('auth:sanctum');

// Payment API
Route::post('/payments', [App\Http\Controllers\PaymentController::class, 'apiStore'])->middleware('auth:sanctum');
Route::post('/payments/upload-proof', [App\Http\Controllers\PaymentController::class, 'apiUploadProof'])->middleware('auth:sanctum');
Route::get('/payments/history', [App\Http\Controllers\PaymentController::class, 'apiHistory'])->middleware('auth:sanctum');

// Announcement API
Route::get('/announcements', [App\Http\Controllers\DashboardController::class, 'apiAnnouncements'])->middleware('auth:sanctum');
Route::get('/announcements/{id}', [App\Http\Controllers\DashboardController::class, 'apiAnnouncementDetail'])->middleware('auth:sanctum');

// Notification API
Route::get('/notifications', [App\Http\Controllers\DashboardController::class, 'apiNotifications'])->middleware('auth:sanctum');
Route::post('/notifications/read', [App\Http\Controllers\DashboardController::class, 'apiMarkNotificationAsRead'])->middleware('auth:sanctum');

// Sanctum user endpoint (existing)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
