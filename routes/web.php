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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('seniors', SeniorController::class);
Route::resource('barangays', BarangayController::class);
Route::resource('payout-cycles', PayoutCycleController::class);
Route::resource('payout-schedules', PayoutScheduleController::class);
Route::resource('document-requirements', DocumentRequirementController::class);
Route::resource('counters', CounterController::class);
Route::resource('staff-assignments', StaffAssignmentController::class);
Route::resource('payout-transactions', PayoutTransactionController::class);
Route::resource('document-submissions', DocumentSubmissionController::class);
Route::resource('reports', ReportController::class);