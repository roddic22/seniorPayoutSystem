<?php

namespace App\Http\Controllers;

use App\Models\PayoutSchedule;
use App\Models\PayoutCycle;
use App\Models\Barangay;
use Illuminate\Http\Request;

class PayoutScheduleController extends Controller
{
    public function index()
    {
        $schedules = PayoutSchedule::with(['cycle', 'barangay'])->latest()->paginate(10);
        return view('payout-schedules.index', compact('schedules'));
    }

    public function create()
    {
        $cycles    = PayoutCycle::where('status', 'active')->get();
        $barangays = Barangay::all();
        return view('payout-schedules.create', compact('cycles', 'barangays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cycle_id'       => 'required|exists:payout_cycles,id',
            'barangay_id'    => 'nullable|exists:barangays,id',
            'scheduled_date' => 'required|date',
            'time_start' => 'nullable|string|max:10',
            'time_end'   => 'nullable|string|max:10',
            'venue'          => 'nullable|string|max:200',
        ]);

        PayoutSchedule::create($request->all());
        return redirect()->route('payout-schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function show(PayoutSchedule $payoutSchedule)
    {
        $payoutSchedule->load(['cycle', 'barangay', 'staffAssignments.user', 'staffAssignments.counter']);
        return view('payout-schedules.show', compact('payoutSchedule'));
    }

    public function edit(PayoutSchedule $payoutSchedule)
{
    $cycles    = PayoutCycle::all();
    $barangays = Barangay::all();
    return view('payout-schedules.edit', compact('payoutSchedule', 'cycles', 'barangays'));
}

   public function update(Request $request, PayoutSchedule $payoutSchedule)
{
    $request->validate([
        'cycle_id'       => 'required|exists:payout_cycles,id',
        'barangay_id'    => 'nullable|exists:barangays,id',
        'scheduled_date' => 'required|date',
        'time_start'     => 'nullable|string|max:10',
        'time_end'       => 'nullable|string|max:10',
        'venue'          => 'nullable|string|max:200',
    ]);

    $payoutSchedule->update([
        'cycle_id'       => $request->cycle_id,
        'barangay_id'    => $request->barangay_id,
        'scheduled_date' => $request->scheduled_date,
        'time_start'     => $request->time_start,
        'time_end'       => $request->time_end,
        'venue'          => $request->venue,
    ]);

    return redirect()->route('payout-schedules.index')
        ->with('success', 'Schedule updated successfully.');
}

    public function destroy(PayoutSchedule $payoutSchedule)
    {
        $payoutSchedule->delete();
        return redirect()->route('payout-schedules.index')->with('success', 'Schedule deleted.');
    }
}