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

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::match(['get','post'], '/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware('auth')->group(function () {

    // ── Dashboard ────────────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── SENIORS (create BEFORE {senior}) ─────────────────────
    Route::get('seniors', [SeniorController::class, 'index'])->name('seniors.index');
    Route::get('seniors/create', [SeniorController::class, 'create'])
        ->middleware('role:admin')->name('seniors.create');
    Route::post('seniors', [SeniorController::class, 'store'])
        ->middleware('role:admin')->name('seniors.store');
    Route::get('seniors/{senior}/edit', [SeniorController::class, 'edit'])
        ->middleware('role:admin')->name('seniors.edit');
    Route::put('seniors/{senior}', [SeniorController::class, 'update'])
        ->middleware('role:admin')->name('seniors.update');
    Route::delete('seniors/{senior}', [SeniorController::class, 'destroy'])
        ->middleware('role:admin')->name('seniors.destroy');
    Route::get('seniors/{senior}', [SeniorController::class, 'show'])->name('seniors.show');

    // ── BARANGAYS (create BEFORE {barangay}) ─────────────────
    Route::get('barangays', [BarangayController::class, 'index'])->name('barangays.index');
    Route::get('barangays/create', [BarangayController::class, 'create'])
        ->middleware('role:admin')->name('barangays.create');
    Route::post('barangays', [BarangayController::class, 'store'])
        ->middleware('role:admin')->name('barangays.store');
    Route::get('barangays/{barangay}/edit', [BarangayController::class, 'edit'])
        ->middleware('role:admin')->name('barangays.edit');
    Route::put('barangays/{barangay}', [BarangayController::class, 'update'])
        ->middleware('role:admin')->name('barangays.update');
    Route::delete('barangays/{barangay}', [BarangayController::class, 'destroy'])
        ->middleware('role:admin')->name('barangays.destroy');
    Route::get('barangays/{barangay}', [BarangayController::class, 'show'])->name('barangays.show');

    // ── PAYOUT CYCLES (create BEFORE {payoutCycle}) ──────────
    Route::get('payout-cycles', [PayoutCycleController::class, 'index'])->name('payout-cycles.index');
    Route::get('payout-cycles/create', [PayoutCycleController::class, 'create'])
        ->middleware('role:admin')->name('payout-cycles.create');
    Route::post('payout-cycles', [PayoutCycleController::class, 'store'])
        ->middleware('role:admin')->name('payout-cycles.store');
    Route::get('payout-cycles/{payoutCycle}/edit', [PayoutCycleController::class, 'edit'])
        ->middleware('role:admin')->name('payout-cycles.edit');
    Route::put('payout-cycles/{payoutCycle}', [PayoutCycleController::class, 'update'])
        ->middleware('role:admin')->name('payout-cycles.update');
    Route::delete('payout-cycles/{payoutCycle}', [PayoutCycleController::class, 'destroy'])
        ->middleware('role:admin')->name('payout-cycles.destroy');
    Route::get('payout-cycles/{payoutCycle}', [PayoutCycleController::class, 'show'])->name('payout-cycles.show');

    // ── PAYOUT SCHEDULES (create BEFORE {payoutSchedule}) ────
    Route::get('payout-schedules', [PayoutScheduleController::class, 'index'])->name('payout-schedules.index');
    Route::get('payout-schedules/create', [PayoutScheduleController::class, 'create'])
        ->middleware('role:admin')->name('payout-schedules.create');
    Route::post('payout-schedules', [PayoutScheduleController::class, 'store'])
        ->middleware('role:admin')->name('payout-schedules.store');
    Route::get('payout-schedules/{payoutSchedule}/edit', [PayoutScheduleController::class, 'edit'])
        ->middleware('role:admin')->name('payout-schedules.edit');
    Route::put('payout-schedules/{payoutSchedule}', [PayoutScheduleController::class, 'update'])
        ->middleware('role:admin')->name('payout-schedules.update');
    Route::delete('payout-schedules/{payoutSchedule}', [PayoutScheduleController::class, 'destroy'])
        ->middleware('role:admin')->name('payout-schedules.destroy');
    Route::get('payout-schedules/{payoutSchedule}', [PayoutScheduleController::class, 'show'])->name('payout-schedules.show');

    // ── DOCUMENT REQUIREMENTS (create BEFORE {documentRequirement}) ──
    Route::get('document-requirements', [DocumentRequirementController::class, 'index'])->name('document-requirements.index');
    Route::get('document-requirements/create', [DocumentRequirementController::class, 'create'])
        ->middleware('role:admin')->name('document-requirements.create');
    Route::post('document-requirements', [DocumentRequirementController::class, 'store'])
        ->middleware('role:admin')->name('document-requirements.store');
    Route::get('document-requirements/{documentRequirement}/edit', [DocumentRequirementController::class, 'edit'])
        ->middleware('role:admin')->name('document-requirements.edit');
    Route::put('document-requirements/{documentRequirement}', [DocumentRequirementController::class, 'update'])
        ->middleware('role:admin')->name('document-requirements.update');
    Route::delete('document-requirements/{documentRequirement}', [DocumentRequirementController::class, 'destroy'])
        ->middleware('role:admin')->name('document-requirements.destroy');
    Route::get('document-requirements/{documentRequirement}', [DocumentRequirementController::class, 'show'])->name('document-requirements.show');

    // ── COUNTERS (admin only) ─────────────────────────────────
    Route::get('counters', [CounterController::class, 'index'])
        ->middleware('role:admin')->name('counters.index');
    Route::get('counters/create', [CounterController::class, 'create'])
        ->middleware('role:admin')->name('counters.create');
    Route::post('counters', [CounterController::class, 'store'])
        ->middleware('role:admin')->name('counters.store');
    Route::get('counters/{counter}/edit', [CounterController::class, 'edit'])
        ->middleware('role:admin')->name('counters.edit');
    Route::put('counters/{counter}', [CounterController::class, 'update'])
        ->middleware('role:admin')->name('counters.update');
    Route::delete('counters/{counter}', [CounterController::class, 'destroy'])
        ->middleware('role:admin')->name('counters.destroy');
    Route::get('counters/{counter}', [CounterController::class, 'show'])
        ->middleware('role:admin')->name('counters.show');

    // ── STAFF ASSIGNMENTS (admin only) ───────────────────────
    Route::get('staff-assignments', [StaffAssignmentController::class, 'index'])
        ->middleware('role:admin')->name('staff-assignments.index');
    Route::get('staff-assignments/create', [StaffAssignmentController::class, 'create'])
        ->middleware('role:admin')->name('staff-assignments.create');
    Route::post('staff-assignments', [StaffAssignmentController::class, 'store'])
        ->middleware('role:admin')->name('staff-assignments.store');
    Route::get('staff-assignments/{staffAssignment}/edit', [StaffAssignmentController::class, 'edit'])
        ->middleware('role:admin')->name('staff-assignments.edit');
    Route::put('staff-assignments/{staffAssignment}', [StaffAssignmentController::class, 'update'])
        ->middleware('role:admin')->name('staff-assignments.update');
    Route::delete('staff-assignments/{staffAssignment}', [StaffAssignmentController::class, 'destroy'])
        ->middleware('role:admin')->name('staff-assignments.destroy');
    Route::get('staff-assignments/{staffAssignment}', [StaffAssignmentController::class, 'show'])
        ->middleware('role:admin')->name('staff-assignments.show');

    // ── PAYOUT TRANSACTIONS (admin + clerk) ──────────────────
    Route::get('payout-transactions', [PayoutTransactionController::class, 'index'])->name('payout-transactions.index');
    Route::get('payout-transactions/create', [PayoutTransactionController::class, 'create'])
        ->middleware('role:admin,clerk')->name('payout-transactions.create');
    Route::post('payout-transactions', [PayoutTransactionController::class, 'store'])
        ->middleware('role:admin,clerk')->name('payout-transactions.store');
    Route::get('payout-transactions/{payoutTransaction}/edit', [PayoutTransactionController::class, 'edit'])
        ->middleware('role:admin')->name('payout-transactions.edit');
    Route::put('payout-transactions/{payoutTransaction}', [PayoutTransactionController::class, 'update'])
        ->middleware('role:admin')->name('payout-transactions.update');
    Route::delete('payout-transactions/{payoutTransaction}', [PayoutTransactionController::class, 'destroy'])
        ->middleware('role:admin')->name('payout-transactions.destroy');
    Route::patch('payout-transactions/{payoutTransaction}/status',
        [PayoutTransactionController::class, 'updateStatus'])
        ->middleware('role:admin,clerk')->name('payout-transactions.updateStatus');
    Route::get('payout-transactions/{payoutTransaction}', [PayoutTransactionController::class, 'show'])->name('payout-transactions.show');

    // ── DOCUMENT SUBMISSIONS (admin + clerk) ─────────────────
    Route::get('document-submissions', [DocumentSubmissionController::class, 'index'])
        ->middleware('role:admin')->name('document-submissions.index');
    Route::get('document-submissions/create', [DocumentSubmissionController::class, 'create'])
        ->middleware('role:admin,clerk')->name('document-submissions.create');
    Route::post('document-submissions', [DocumentSubmissionController::class, 'store'])
        ->middleware('role:admin,clerk')->name('document-submissions.store');
    Route::get('document-submissions/{documentSubmission}/edit', [DocumentSubmissionController::class, 'edit'])
        ->middleware('role:admin,clerk')->name('document-submissions.edit');
    Route::put('document-submissions/{documentSubmission}', [DocumentSubmissionController::class, 'update'])
        ->middleware('role:admin,clerk')->name('document-submissions.update');
    Route::delete('document-submissions/{documentSubmission}', [DocumentSubmissionController::class, 'destroy'])
        ->middleware('role:admin')->name('document-submissions.destroy');
    Route::get('document-submissions/{documentSubmission}', [DocumentSubmissionController::class, 'show'])
        ->middleware('role:admin,clerk')->name('document-submissions.show');

    // ── REPORTS (admin + clerk) ───────────────────────────────
    Route::post('reports/generate', [ReportController::class, 'generate'])
        ->middleware('role:admin,clerk')->name('reports.generate');
    Route::get('reports', [ReportController::class, 'index'])
        ->middleware('role:admin,clerk')->name('reports.index');
    Route::get('reports/{report}', [ReportController::class, 'show'])
        ->middleware('role:admin,clerk')->name('reports.show');
    Route::delete('reports/{report}', [ReportController::class, 'destroy'])
        ->middleware('role:admin')->name('reports.destroy');

    // ── STAFF MANAGEMENT (admin only) ────────────────────────
    Route::get('staff', [StaffController::class, 'index'])
        ->middleware('role:admin')->name('staff.index');
    Route::get('staff/create', [StaffController::class, 'create'])
        ->middleware('role:admin')->name('staff.create');
    Route::post('staff', [StaffController::class, 'store'])
        ->middleware('role:admin')->name('staff.store');
    Route::get('staff/{staff}/edit', [StaffController::class, 'edit'])
        ->middleware('role:admin')->name('staff.edit');
    Route::put('staff/{staff}', [StaffController::class, 'update'])
        ->middleware('role:admin')->name('staff.update');
    Route::delete('staff/{staff}', [StaffController::class, 'destroy'])
        ->middleware('role:admin')->name('staff.destroy');
    Route::get('staff/{staff}', [StaffController::class, 'show'])
        ->middleware('role:admin')->name('staff.show');

    // ── EXPLAIN DEMO (admin only) ─────────────────────────────
    Route::get('/explain-demo', function () {
        $results = DB::select("
            EXPLAIN SELECT payout_transactions.id,
            payout_transactions.amount,
            payout_transactions.claim_status
            FROM payout_transactions
            JOIN seniors ON seniors.id = payout_transactions.senior_id
            WHERE payout_transactions.claim_status = 'claimed'
        ");
        return view('explain-demo', ['results' => $results]);
    })->middleware('role:admin')->name('explain.demo');
});