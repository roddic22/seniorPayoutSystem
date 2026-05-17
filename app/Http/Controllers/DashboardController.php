<?php

namespace App\Http\Controllers;

use App\Models\Senior;
use App\Models\PayoutCycle;
use App\Models\PayoutTransaction;
use App\Models\Barangay;
use App\Models\Counter;
use App\Models\PayoutSchedule;
use App\Models\StaffAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (in_array(Auth::user()?->role, ['staff', 'clerk'], true)) {
            $staffAssignments = StaffAssignment::with(['schedule.cycle', 'schedule.barangay', 'counter'])
                ->where('user_id', Auth::id())
                ->join('payout_schedules', 'staff_assignments.schedule_id', '=', 'payout_schedules.id')
                ->orderByRaw('payout_schedules.scheduled_date IS NULL')
                ->orderBy('payout_schedules.scheduled_date')
                ->select('staff_assignments.*')
                ->get();

            $today = now()->toDateString();
            $nextAssignment = $staffAssignments
                ->filter(fn($a) => ($a->schedule?->scheduled_date ?? null) >= $today)
                ->first() ?? $staffAssignments->first();
            $upcomingAssignmentCount = $staffAssignments
                ->filter(fn($a) => ($a->schedule?->scheduled_date ?? null) >= $today)
                ->count();

            return view('dashboard', compact(
                'staffAssignments',
                'nextAssignment',
                'upcomingAssignmentCount'
            ));
        }

        // ── Cached KPI counts (10 min TTL) ──────────────────────────
        $totalSeniors   = Cache::remember('kpi_seniors',   600, fn() => Senior::count());
        $totalCycles    = Cache::remember('kpi_cycles',    600, fn() => PayoutCycle::count());
        $totalBarangays = Cache::remember('kpi_barangays', 600, fn() => Barangay::count());
        $totalCounters  = Cache::remember('kpi_counters',  600, fn() => Counter::count());

        // ── Transaction stats (5 min TTL — changes more frequently) ─
        $totalClaimed   = Cache::remember('kpi_claimed',   300, fn() =>
            PayoutTransaction::where('claim_status', 'claimed')->count());
        $totalUnclaimed = Cache::remember('kpi_unclaimed', 300, fn() =>
            PayoutTransaction::where('claim_status', 'unclaimed')->count());
        $totalCancelled = Cache::remember('kpi_cancelled', 300, fn() =>
            PayoutTransaction::where('claim_status', 'cancelled')->count());
        $totalAmount    = Cache::remember('kpi_amount',    300, fn() =>
            PayoutTransaction::where('claim_status', 'claimed')->sum('amount'));

        // ── Active cycles (10 min TTL) ───────────────────────────────
        $activeCycles = Cache::remember('kpi_active_cycles', 600, fn() =>
            PayoutCycle::where('status', 'active')->get());

        // ── Upcoming schedules (5 min TTL) ───────────────────────────
        $upcomingSchedules = Cache::remember('kpi_upcoming_schedules', 300, fn() =>
            PayoutSchedule::with(['cycle', 'barangay'])
                ->where('scheduled_date', '>=', now()->toDateString())
                ->orderBy('scheduled_date')
                ->take(5)
                ->get());

        // ── Monthly breakdown (5 min TTL) ────────────────────────────
        $byMonth = Cache::remember('kpi_by_month', 300, fn() =>
            PayoutTransaction::select(
                DB::raw('DATE_FORMAT(created_at, "%b %Y") as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month_num'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN claim_status = "claimed" THEN 1 ELSE 0 END) as claimed'),
                DB::raw('SUM(CASE WHEN claim_status = "unclaimed" THEN 1 ELSE 0 END) as unclaimed'),
                DB::raw('SUM(CASE WHEN claim_status = "claimed" THEN amount ELSE 0 END) as amount_released')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month', 'year', 'month_num')
            ->orderBy('year')
            ->orderBy('month_num')
            ->get());

        // ── By barangay (5 min TTL) ───────────────────────────────────
        $byBarangay = Cache::remember('kpi_by_barangay', 300, fn() =>
            Barangay::select(
                'barangays.id',
                'barangays.name',
                DB::raw('COUNT(payout_transactions.id) as total'),
                DB::raw('SUM(CASE WHEN payout_transactions.claim_status = "claimed" THEN 1 ELSE 0 END) as claimed'),
                DB::raw('SUM(CASE WHEN payout_transactions.claim_status = "unclaimed" THEN 1 ELSE 0 END) as unclaimed'),
                DB::raw('SUM(CASE WHEN payout_transactions.claim_status = "claimed" THEN payout_transactions.amount ELSE 0 END) as amount_released')
            )
            ->leftJoin('seniors', 'seniors.barangay_id', '=', 'barangays.id')
            ->leftJoin('payout_transactions', 'payout_transactions.senior_id', '=', 'seniors.id')
            ->groupBy('barangays.id', 'barangays.name')
            ->orderByDesc('total')
            ->get());

        return view('dashboard', compact(
            'totalSeniors', 'totalCycles', 'totalBarangays',
            'totalCounters', 'totalClaimed', 'totalUnclaimed',
            'totalCancelled', 'totalAmount', 'activeCycles',
            'upcomingSchedules', 'byMonth', 'byBarangay'
        ));
    }
}