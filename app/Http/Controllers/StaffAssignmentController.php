<?php

namespace App\Http\Controllers;

use App\Models\StaffAssignment;
use App\Models\PayoutSchedule;
use App\Models\Counter;
use App\Models\User;
use Illuminate\Http\Request;

class StaffAssignmentController extends Controller
{
    public function index()
    {
        $assignments = StaffAssignment::with(['schedule.cycle', 'schedule.barangay', 'user', 'counter'])
            ->latest()->paginate(10);
        return view('staff-assignments.index', compact('assignments'));
    }

    public function create()
    {
        $schedules = PayoutSchedule::with(['cycle', 'barangay'])->get();
        $counters  = Counter::where('is_active', 1)->get();
        $users     = User::all();
        return view('staff-assignments.create', compact('schedules', 'counters', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:payout_schedules,id',
            'user_id'     => 'required|exists:users,id',
            'counter_id'  => 'required|exists:counters,id',
        ]);

        $exists = StaffAssignment::where('schedule_id', $request->schedule_id)
            ->where('counter_id', $request->counter_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['counter_id' => 'This counter is already assigned for that schedule.']);
        }

        StaffAssignment::create($request->all());
        return redirect()->route('staff-assignments.index')
            ->with('success', 'Staff assigned successfully.');
    }

    public function show(StaffAssignment $staffAssignment)
    {
        $staffAssignment->load(['schedule.cycle', 'schedule.barangay', 'user', 'counter']);
        return view('staff-assignments.show', compact('staffAssignment'));
    }

    public function edit(StaffAssignment $staffAssignment)
    {
        $schedules = PayoutSchedule::with(['cycle', 'barangay'])->get();
        $counters  = Counter::where('is_active', 1)->get();
        $users     = User::all();
        return view('staff-assignments.edit', compact('staffAssignment', 'schedules', 'counters', 'users'));
    }

    public function update(Request $request, StaffAssignment $staffAssignment)
    {
        $request->validate([
            'schedule_id' => 'required|exists:payout_schedules,id',
            'user_id'     => 'required|exists:users,id',
            'counter_id'  => 'required|exists:counters,id',
        ]);

        $exists = StaffAssignment::where('schedule_id', $request->schedule_id)
            ->where('counter_id', $request->counter_id)
            ->where('id', '!=', $staffAssignment->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['counter_id' => 'This counter is already assigned for that schedule.']);
        }

        $staffAssignment->update($request->all());
        return redirect()->route('staff-assignments.index')
            ->with('success', 'Staff assignment updated.');
    }

    public function destroy(StaffAssignment $staffAssignment)
    {
        $staffAssignment->delete();
        return redirect()->route('staff-assignments.index')
            ->with('success', 'Staff assignment removed.');
    }
}