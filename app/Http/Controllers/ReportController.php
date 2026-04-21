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

        $cycle        = PayoutCycle::findOrFail($request->cycle_id);
        $transactions = PayoutTransaction::with('senior')
            ->where('cycle_id', $cycle->id)->get();

        $totalSeniors   = $transactions->count();
        $totalClaimed   = $transactions->where('claim_status', 'claimed')->count();
        $totalUnclaimed = $transactions->where('claim_status', 'unclaimed')->count();
        $totalCancelled = $transactions->where('claim_status', 'cancelled')->count();
        $totalAmount    = $transactions->where('claim_status', 'claimed')->sum('amount');

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