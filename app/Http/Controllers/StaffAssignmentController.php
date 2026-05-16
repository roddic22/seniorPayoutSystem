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
        $assignments = StaffAssignment::with([
            'schedule.cycle',
            'schedule.barangay',
            'user',
            'counter'
        ])->latest()->paginate(10);
        return view('staff-assignments.index', compact('assignments'));
    }

    public function create()
    {
        $schedules = PayoutSchedule::with(['cycle', 'barangay'])->get();
        $counters  = Counter::where('is_active', 1)->get();
        // Exclude admin from staff dropdown
        $users = User::where('role', 'clerk')->get();
        return view('staff-assignments.create', compact('schedules', 'counters', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:payout_schedules,id',
            'user_id'     => 'required|exists:users,id',
            'counter_id'  => 'required|exists:counters,id',
        ]);

        // Check duplicate — same staff on same schedule
        $duplicateStaff = StaffAssignment::where('schedule_id', $request->schedule_id)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($duplicateStaff) {
            return back()
                ->withInput()
                ->with('assignment_error', 'This staff member is already assigned to the selected schedule.');
        }

        // Check duplicate — same counter on same schedule
        $duplicateCounter = StaffAssignment::where('schedule_id', $request->schedule_id)
            ->where('counter_id', $request->counter_id)
            ->exists();

        if ($duplicateCounter) {
            return back()
                ->withInput()
                ->with('assignment_error', 'This counter is already assigned for the selected schedule.');
        }

        StaffAssignment::create($request->all());
        return redirect()->route('staff-assignments.index')
            ->with('success', 'Staff assigned successfully.');
    }

    public function show(StaffAssignment $staffAssignment)
    {
        $staffAssignment->load([
            'schedule.cycle',
            'schedule.barangay',
            'user',
            'counter'
        ]);
        return view('staff-assignments.show', compact('staffAssignment'));
    }

    public function edit(StaffAssignment $staffAssignment)
    {
        $schedules = PayoutSchedule::with(['cycle', 'barangay'])->get();
        $counters  = Counter::where('is_active', 1)->get();
        // Exclude admin from staff dropdown
        $users = User::where('role', 'clerk')->get();
        return view('staff-assignments.edit', compact(
            'staffAssignment', 'schedules', 'counters', 'users'
        ));
    }

    public function update(Request $request, StaffAssignment $staffAssignment)
    {
        $request->validate([
            'schedule_id' => 'required|exists:payout_schedules,id',
            'user_id'     => 'required|exists:users,id',
            'counter_id'  => 'required|exists:counters,id',
        ]);

        // Check duplicate staff on same schedule (exclude current record)
        $duplicateStaff = StaffAssignment::where('schedule_id', $request->schedule_id)
            ->where('user_id', $request->user_id)
            ->where('id', '!=', $staffAssignment->id)
            ->exists();

        if ($duplicateStaff) {
            return back()
                ->withInput()
                ->with('assignment_error', 'This staff member is already assigned to the selected schedule.');
        }

        // Check duplicate counter on same schedule (exclude current record)
        $duplicateCounter = StaffAssignment::where('schedule_id', $request->schedule_id)
            ->where('counter_id', $request->counter_id)
            ->where('id', '!=', $staffAssignment->id)
            ->exists();

        if ($duplicateCounter) {
            return back()
                ->withInput()
                ->with('assignment_error', 'This counter is already assigned for the selected schedule.');
        }

        $staffAssignment->update([
            'schedule_id' => $request->schedule_id,
            'user_id'     => $request->user_id,
            'counter_id'  => $request->counter_id,
        ]);

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