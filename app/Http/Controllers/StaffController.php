<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::oldest()->paginate(10);
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,staff,clerk',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('staff.index')
            ->with('success', 'Staff member added successfully.');
    }

    public function show(User $staff)
    {
        $assignments = $staff->staffAssignments()
            ->with(['schedule.cycle', 'schedule.barangay', 'counter'])
            ->oldest()->get();
        return view('staff.show', compact('staff', 'assignments'));
    }

    public function edit(User $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'role'  => 'required|in:admin,staff,clerk',
        ]);

        $staff->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $staff->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('staff.index')
            ->with('success', 'Staff member updated.');
    }

    public function destroy(User $staff)
    {
        if ($staff->id === auth()->id()) {
            return redirect()->route('staff.index')
                ->withErrors(['error' => 'You cannot delete your own account.']);
        }

        $staff->delete();
        return redirect()->route('staff.index')
            ->with('success', 'Staff member removed.');
    }
}
