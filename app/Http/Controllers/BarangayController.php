<?php

namespace App\Http\Controllers;
use App\Models\Barangay;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    public function index()
    {
        $barangays = Barangay::oldest()->paginate(10);
        return view('barangays.index', compact('barangays'));
    }

    public function create()
    {
        return view('barangays.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:barangays,name',
            'city' => 'required|string|max:255',
        ]);

        Barangay::create($request->all());
        return redirect()->route('barangays.index')->with('success', 'Barangay added successfully.');
    }

    public function show(Barangay $barangay)
    {
        $seniors = $barangay->seniors()->paginate(10);
        return view('barangays.show', compact('barangay', 'seniors'));
    }

    public function edit(Barangay $barangay)
    {
        return view('barangays.edit', compact('barangay'));
    }

    public function update(Request $request, Barangay $barangay)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:barangays,name,' . $barangay->id,
            'city' => 'required|string|max:255',
        ]);

        $barangay->update($request->all());
        return redirect()->route('barangays.index')->with('success', 'Barangay updated successfully.');
    }

    public function destroy(Barangay $barangay)
    {
        $barangay->delete();
        return redirect()->route('barangays.index')->with('success', 'Barangay deleted.');
    }
}
