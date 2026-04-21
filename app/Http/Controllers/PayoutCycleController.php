<?php

namespace App\Http\Controllers;

use App\Models\PayoutCycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayoutCycleController extends Controller
{
    public function index()
    {
        $cycles = PayoutCycle::latest()->paginate(10);
        return view('payout-cycles.index', compact('cycles'));
    }

    public function create()
    {
        return view('payout-cycles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cycle_name'   => 'required|string|max:255',
            'period_start' => 'required|date',
            'period_end'   => 'required|date|after_or_equal:period_start',
            'status'       => 'required|in:draft,active,completed',
        ]);

        PayoutCycle::create([
            'cycle_name'   => $request->cycle_name,
            'period_start' => $request->period_start,
            'period_end'   => $request->period_end,
            'status'       => $request->status,
            'created_by'   => Auth::id(),
        ]);

        return redirect()->route('payout-cycles.index')->with('success', 'Payout cycle created successfully.');
    }

    public function show(PayoutCycle $payoutCycle)
    {
        $schedules = $payoutCycle->schedules()->with('barangay')->get();
        $requirements = $payoutCycle->requirements()->get();
        $transactions = $payoutCycle->transactions()->with('senior')->get();

        $totalClaimed   = $transactions->where('claim_status', 'claimed')->count();
        $totalUnclaimed = $transactions->where('claim_status', 'unclaimed')->count();

        return view('payout-cycles.show', compact(
            'payoutCycle', 'schedules', 'requirements',
            'transactions', 'totalClaimed', 'totalUnclaimed'
        ));
    }

    public function edit(PayoutCycle $payoutCycle)
    {
        return view('payout-cycles.edit', compact('payoutCycle'));
    }

    public function update(Request $request, PayoutCycle $payoutCycle)
    {
        $request->validate([
            'cycle_name'   => 'required|string|max:255',
            'period_start' => 'required|date',
            'period_end'   => 'required|date|after_or_equal:period_start',
            'status'       => 'required|in:draft,active,completed',
        ]);

        $payoutCycle->update($request->only('cycle_name', 'period_start', 'period_end', 'status'));
        return redirect()->route('payout-cycles.index')->with('success', 'Payout cycle updated.');
    }

    public function destroy(PayoutCycle $payoutCycle)
    {
        $payoutCycle->delete();
        return redirect()->route('payout-cycles.index')->with('success', 'Payout cycle deleted.');
    }
}