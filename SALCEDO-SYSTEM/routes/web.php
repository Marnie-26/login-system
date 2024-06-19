<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestRecordController;
use App\Http\Controllers\KeyRecordController;
use App\Http\Controllers\WorkPermitRecordController;

Route::get('/admin-login', [LoginController::class, 'index'])->name('admin.login');
Route::post('/admin-login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/main-dashboard', [DashboardController::class, 'main_dashboard'])->name('main.dashboard');

Route::get('/guest-login', [GuestRecordController::class, 'index'])->name('guest.login');
Route::post('/guests-store', [GuestRecordController::class, 'store'])->name('guests.store');
Route::get('/view-guest-record', [GuestRecordController::class, 'view_guest_record'])->name('view.guest.record');
Route::delete('/delete-guest-record/{id}', [GuestRecordController::class, 'delete_guest_record'])->name('delete.guest.record');
Route::post('/log-time-out', [GuestRecordController::class, 'log_time_out'])->name('log.time.out');
Route::post('/update-guest-record', [GuestRecordController::class, 'update_guest_record'])->name('update.guest.record');
Route::get('/search-guest-record', [GuestRecordController::class, 'search_guest_record'])->name('search.guest.record');
Route::get('/export-excel', [GuestRecordController::class, 'export_excel'])->name('export.excel');

Route::get('/visit-log-key', [KeyRecordController::class, 'visit_log_key'])->name('visit.log.key');
Route::post('/keys-store', [KeyRecordController::class, 'store'])->name('keys.store');
Route::get('/view-key-record', [KeyRecordController::class, 'view_key_record'])->name('view.key.record');
Route::get('/keys-export-excel', [KeyRecordController::class, 'keys_export_excel'])->name('keys.export.excel');
Route::get('/search-key-record', [KeyRecordController::class, 'search_key_record'])->name('search.key.record');
Route::post('/log-time-returned', [KeyRecordController::class, 'log_time_returned'])->name('log.time.returned');
Route::delete('/delete-key-record/{id}', [KeyRecordController::class, 'delete_key_record'])->name('delete.key.record');
Route::post('/update-key-record', [KeyRecordController::class, 'update_key_record'])->name('update.key.record');

Route::get('/visit-log-permit', [WorkPermitRecordController::class, 'visit_log_permit'])->name('visit.log.permit');
Route::post('/permit-store', [WorkPermitRecordController::class, 'store'])->name('permit.store');
Route::get('/view-permit-record', [WorkPermitRecordController::class, 'view_permit_record'])->name('view.permit.record');
Route::get('/permits-export-excel', [WorkPermitRecordController::class, 'permits_export_excel'])->name('permits.export.excel');
Route::get('/search-permit-record', [WorkPermitRecordController::class, 'search_permit_record'])->name('search.permit.record');
Route::delete('/delete-permit-record/{id}', [WorkPermitRecordController::class, 'delete_permit_record'])->name('delete.permit.record');
Route::post('/update-permit-record', [WorkPermitRecordController::class, 'update_permit_record'])->name('update.permit.record');