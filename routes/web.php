<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

// ─── Authenticated routes (all roles) ────────────────────────
Route::middleware('auth')->group(function () {

    // Dashboard — everyone
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── VIEW ONLY for staff (index + show) ──────────────────
    Route::get('seniors',                [SeniorController::class, 'index'])->name('seniors.index');
    Route::get('seniors/{senior}',       [SeniorController::class, 'show'])->name('seniors.show');

    Route::get('barangays',              [BarangayController::class, 'index'])->name('barangays.index');
    Route::get('barangays/{barangay}',   [BarangayController::class, 'show'])->name('barangays.show');

    Route::get('payout-cycles',                    [PayoutCycleController::class, 'index'])->name('payout-cycles.index');
    Route::get('payout-cycles/{payoutCycle}',      [PayoutCycleController::class, 'show'])->name('payout-cycles.show');

    Route::get('payout-schedules',                 [PayoutScheduleController::class, 'index'])->name('payout-schedules.index');
    Route::get('payout-schedules/{payoutSchedule}',[PayoutScheduleController::class, 'show'])->name('payout-schedules.show');

    Route::get('document-requirements',                          [DocumentRequirementController::class, 'index'])->name('document-requirements.index');
    Route::get('document-requirements/{documentRequirement}',    [DocumentRequirementController::class, 'show'])->name('document-requirements.show');

    // Transactions — full access for everyone
    Route::resource('payout-transactions', PayoutTransactionController::class);
    Route::patch('payout-transactions/{payoutTransaction}/status',
        [PayoutTransactionController::class, 'updateStatus'])
        ->name('payout-transactions.updateStatus');

    Route::resource('document-submissions', DocumentSubmissionController::class);

    // Reports — view + generate for everyone
    Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::get('reports',           [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/{report}',  [ReportController::class, 'show'])->name('reports.show');

    // ── ADMIN ONLY routes ────────────────────────────────────
    Route::middleware('role:admin')->group(function () {

        // Seniors — create/edit/delete
        Route::get('seniors/create',            [SeniorController::class, 'create'])->name('seniors.create');
        Route::post('seniors',                  [SeniorController::class, 'store'])->name('seniors.store');
        Route::get('seniors/{senior}/edit',     [SeniorController::class, 'edit'])->name('seniors.edit');
        Route::put('seniors/{senior}',          [SeniorController::class, 'update'])->name('seniors.update');
        Route::delete('seniors/{senior}',       [SeniorController::class, 'destroy'])->name('seniors.destroy');

        // Barangays — create/edit/delete
        Route::get('barangays/create',          [BarangayController::class, 'create'])->name('barangays.create');
        Route::post('barangays',                [BarangayController::class, 'store'])->name('barangays.store');
        Route::get('barangays/{barangay}/edit', [BarangayController::class, 'edit'])->name('barangays.edit');
        Route::put('barangays/{barangay}',      [BarangayController::class, 'update'])->name('barangays.update');
        Route::delete('barangays/{barangay}',   [BarangayController::class, 'destroy'])->name('barangays.destroy');

        // Payout Cycles — create/edit/delete
        Route::get('payout-cycles/create',               [PayoutCycleController::class, 'create'])->name('payout-cycles.create');
        Route::post('payout-cycles',                     [PayoutCycleController::class, 'store'])->name('payout-cycles.store');
        Route::get('payout-cycles/{payoutCycle}/edit',   [PayoutCycleController::class, 'edit'])->name('payout-cycles.edit');
        Route::put('payout-cycles/{payoutCycle}',        [PayoutCycleController::class, 'update'])->name('payout-cycles.update');
        Route::delete('payout-cycles/{payoutCycle}',     [PayoutCycleController::class, 'destroy'])->name('payout-cycles.destroy');

        // Payout Schedules — create/edit/delete
        Route::get('payout-schedules/create',                  [PayoutScheduleController::class, 'create'])->name('payout-schedules.create');
        Route::post('payout-schedules',                        [PayoutScheduleController::class, 'store'])->name('payout-schedules.store');
        Route::get('payout-schedules/{payoutSchedule}/edit',   [PayoutScheduleController::class, 'edit'])->name('payout-schedules.edit');
        Route::put('payout-schedules/{payoutSchedule}',        [PayoutScheduleController::class, 'update'])->name('payout-schedules.update');
        Route::delete('payout-schedules/{payoutSchedule}',     [PayoutScheduleController::class, 'destroy'])->name('payout-schedules.destroy');

        // Document Requirements — create/edit/delete
        Route::get('document-requirements/create',                       [DocumentRequirementController::class, 'create'])->name('document-requirements.create');
        Route::post('document-requirements',                             [DocumentRequirementController::class, 'store'])->name('document-requirements.store');
        Route::get('document-requirements/{documentRequirement}/edit',   [DocumentRequirementController::class, 'edit'])->name('document-requirements.edit');
        Route::put('document-requirements/{documentRequirement}',        [DocumentRequirementController::class, 'update'])->name('document-requirements.update');
        Route::delete('document-requirements/{documentRequirement}',     [DocumentRequirementController::class, 'destroy'])->name('document-requirements.destroy');

        // Admin-only modules
        Route::resource('counters', CounterController::class);
        Route::resource('staff-assignments', StaffAssignmentController::class);
        Route::resource('staff', StaffController::class);

        // Reports — delete
        Route::delete('reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');

        // EXPLAIN demo
        Route::get('/explain-demo', function () {
            $results = DB::select("
                EXPLAIN SELECT payout_transactions.id, payout_transactions.amount,
                payout_transactions.claim_status
                FROM payout_transactions
                JOIN seniors ON seniors.id = payout_transactions.senior_id
                WHERE payout_transactions.claim_status = 'claimed'
            ");
            return view('explain-demo', ['results' => $results]);
        })->name('explain.demo');
    });
});