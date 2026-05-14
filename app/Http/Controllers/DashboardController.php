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

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()?->role === 'staff') {
            $staffAssignments = StaffAssignment::with(['schedule.cycle', 'schedule.barangay', 'counter'])
                ->where('user_id', auth()->id())
                ->join('payout_schedules', 'staff_assignments.schedule_id', '=', 'payout_schedules.id')
                ->orderByRaw('payout_schedules.scheduled_date IS NULL')
                ->orderBy('payout_schedules.scheduled_date')
                ->select('staff_assignments.*')
                ->get();

            return view('dashboard', compact('staffAssignments'));
        }

        // KPI counts
        $totalSeniors   = Senior::count();
        $totalCycles    = PayoutCycle::count();
        $totalBarangays = Barangay::count();
        $totalCounters  = Counter::count();
        $totalClaimed   = PayoutTransaction::where('claim_status', 'claimed')->count();
        $totalUnclaimed = PayoutTransaction::where('claim_status', 'unclaimed')->count();
        $totalCancelled = PayoutTransaction::where('claim_status', 'cancelled')->count();
        $totalAmount    = PayoutTransaction::where('claim_status', 'claimed')->sum('amount');

        // Active cycles
        $activeCycles = PayoutCycle::where('status', 'active')->get();

        // Upcoming schedules
        $upcomingSchedules = PayoutSchedule::with(['cycle', 'barangay'])
            ->where('scheduled_date', '>=', now()->toDateString())
            ->orderBy('scheduled_date')
            ->take(5)
            ->get();

        // Transactions by month (last 6 months)
        $byMonth = PayoutTransaction::select(
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
            ->get();

        // Transactions by barangay
        $byBarangay = Barangay::select(
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
            ->get();

        return view('dashboard', compact(
            'totalSeniors', 'totalCycles', 'totalBarangays',
            'totalCounters', 'totalClaimed', 'totalUnclaimed',
            'totalCancelled', 'totalAmount', 'activeCycles',
            'upcomingSchedules', 'byMonth', 'byBarangay'
        ));
    }
}
