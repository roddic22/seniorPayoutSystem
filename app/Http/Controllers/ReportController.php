<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\PayoutCycle;
use App\Models\PayoutTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $cycles  = PayoutCycle::latest()->get();
        $reports = Report::with(['cycle', 'generator'])->latest()->paginate(10);
        return view('reports.index', compact('cycles', 'reports'));
    }

   public function generate(Request $request)
{
    $request->validate([
        'cycle_id' => 'required|exists:payout_cycles,id',
    ]);

    $cycle = PayoutCycle::findOrFail($request->cycle_id);

    // SELECT specific columns only — avoid SELECT * (Module 3)
    $transactions = PayoutTransaction::select(
            'payout_transactions.id',
            'payout_transactions.amount',
            'payout_transactions.claim_status',
            'payout_transactions.claimed_at',
            'seniors.name as senior_name',
            'seniors.osca_id'
        )
        ->join('seniors', 'seniors.id', '=', 'payout_transactions.senior_id')
        // WHERE clause filters at DB level — not collection filtering (Module 3)
        ->where('payout_transactions.cycle_id', $cycle->id)
        ->get();

    // WHERE instead of HAVING for aggregates — Module 3
    $totalClaimed = PayoutTransaction::where('cycle_id', $cycle->id)
        ->where('claim_status', 'claimed')
        ->count();

    $totalUnclaimed = PayoutTransaction::where('cycle_id', $cycle->id)
        ->where('claim_status', 'unclaimed')
        ->count();

    $totalCancelled = PayoutTransaction::where('cycle_id', $cycle->id)
        ->where('claim_status', 'cancelled')
        ->count();

    $totalAmount = PayoutTransaction::where('cycle_id', $cycle->id)
        ->where('claim_status', 'claimed')
        ->sum('amount');

    $totalSeniors = $transactions->count();

    Report::create([
        'cycle_id'     => $cycle->id,
        'generated_by' => Auth::id(),
        'report_type'  => 'Summary Report',
        'generated_at' => now(),
    ]);

    return view('reports.show', compact(
        'cycle', 'transactions',
        'totalSeniors', 'totalClaimed',
        'totalUnclaimed', 'totalCancelled', 'totalAmount'
    ));
}

    public function show(Report $report)
    {
        $cycle        = $report->cycle;
        $transactions = PayoutTransaction::with('senior')
            ->where('cycle_id', $cycle->id)->get();

        $totalSeniors   = $transactions->count();
        $totalClaimed   = $transactions->where('claim_status', 'claimed')->count();
        $totalUnclaimed = $transactions->where('claim_status', 'unclaimed')->count();
        $totalCancelled = $transactions->where('claim_status', 'cancelled')->count();
        $totalAmount    = $transactions->where('claim_status', 'claimed')->sum('amount');

        return view('reports.show', compact(
            'cycle', 'transactions',
            'totalSeniors', 'totalClaimed',
            'totalUnclaimed', 'totalCancelled', 'totalAmount'
        ));
    }

    public function create() { return redirect()->route('reports.index'); }
    public function store()  { return redirect()->route('reports.index'); }
    public function edit()   { return redirect()->route('reports.index'); }
    public function update() { return redirect()->route('reports.index'); }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted.');
    }
}