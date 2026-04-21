<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index()
    {
        $counters = Counter::latest()->paginate(10);
        return view('counters.index', compact('counters'));
    }

    public function create()
    {
        return view('counters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'counter_number' => 'required|string|max:20|unique:counters,counter_number',
            'label'          => 'nullable|string|max:100',
            'is_active'      => 'boolean',
        ]);

        Counter::create([
            'counter_number' => $request->counter_number,
            'label'          => $request->label,
            'is_active'      => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('counters.index')->with('success', 'Counter added successfully.');
    }

    public function show(Counter $counter)
    {
        return view('counters.show', compact('counter'));
    }

    public function edit(Counter $counter)
    {
        return view('counters.edit', compact('counter'));
    }

    public function update(Request $request, Counter $counter)
    {
        $request->validate([
            'counter_number' => 'required|string|max:20|unique:counters,counter_number,' . $counter->id,
            'label'          => 'nullable|string|max:100',
        ]);

        $counter->update([
            'counter_number' => $request->counter_number,
            'label'          => $request->label,
            'is_active'      => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('counters.index')->with('success', 'Counter updated.');
    }

    public function destroy(Counter $counter)
    {
        $counter->delete();
        return redirect()->route('counters.index')->with('success', 'Counter deleted.');
    }
}