<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeniorController;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\PayoutCycleController;
use App\Http\Controllers\PayoutScheduleController;
use App\Http\Controllers\DocumentRequirementController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\StaffAssignmentController;
use App\Http\Controllers\PayoutTransactionController;
use App\Http\Controllers\DocumentSubmissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('seniors', SeniorController::class);
Route::resource('barangays', BarangayController::class);
Route::resource('payout-cycles', PayoutCycleController::class);
Route::resource('payout-schedules', PayoutScheduleController::class);
Route::resource('document-requirements', DocumentRequirementController::class);
Route::resource('counters', CounterController::class);
Route::resource('staff-assignments', StaffAssignmentController::class);

Route::resource('payout-transactions', PayoutTransactionController::class);
Route::patch('payout-transactions/{payoutTransaction}/status', [PayoutTransactionController::class, 'updateStatus'])
    ->name('payout-transactions.updateStatus');

Route::resource('document-submissions', DocumentSubmissionController::class);

Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
Route::resource('reports', ReportController::class);