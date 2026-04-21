<?php

namespace App\Http\Controllers;

use App\Models\Senior;
use App\Models\PayoutCycle;
use App\Models\PayoutTransaction;
use App\Models\Barangay;
use App\Models\Counter;
use App\Models\PayoutSchedule;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSeniors      = Senior::count();
        $totalCycles       = PayoutCycle::count();
        $totalBarangays    = Barangay::count();
        $totalCounters     = Counter::count();
        $totalClaimed      = PayoutTransaction::where('claim_status', 'claimed')->count();
        $totalUnclaimed    = PayoutTransaction::where('claim_status', 'unclaimed')->count();
        $totalCancelled    = PayoutTransaction::where('claim_status', 'cancelled')->count();
        $totalAmount       = PayoutTransaction::where('claim_status', 'claimed')->sum('amount');
        $activeCycles      = PayoutCycle::where('status', 'active')->get();
        $upcomingSchedules = PayoutSchedule::with(['cycle', 'barangay'])
            ->where('scheduled_date', '>=', now()->toDateString())
            ->orderBy('scheduled_date')
            ->take(5)
            ->get();
        $recentTransactions = PayoutTransaction::with(['senior', 'cycle'])
            ->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalSeniors', 'totalCycles', 'totalBarangays',
            'totalCounters', 'totalClaimed', 'totalUnclaimed',
            'totalCancelled', 'totalAmount', 'activeCycles',
            'upcomingSchedules', 'recentTransactions'
        ));
    }
}