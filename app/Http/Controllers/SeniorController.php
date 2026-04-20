<?php

namespace App\Http\Controllers;

use App\Models\Senior;
use App\Models\Barangay;
use Illuminate\Http\Request;

class SeniorController extends Controller
{
    public function index()
    {
        $seniors = Senior::with('barangay')->latest()->paginate(10);
        return view('seniors.index', compact('seniors'));
    }

    public function create()
    {
        $barangays = Barangay::all();
        return view('seniors.create', compact('barangays'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'osca_id'    => 'required|unique:seniors,osca_id',
            'name'       => 'required|string|max:255',
            'address'    => 'required|string',
            'age'        => 'required|integer|min:60',
            'birthdate'  => 'nullable|date',
            'sex'        => 'nullable|in:male,female',
            'contact_number' => 'nullable|string|max:20',
            'barangay_id'    => 'nullable|exists:barangays,id',
        ]);

        Senior::create($request->all());
        return redirect()->route('seniors.index')->with('success', 'Senior citizen registered successfully.');
    }

    public function show(Senior $senior)
    {
        return view('seniors.show', compact('senior'));
    }

    public function edit(Senior $senior)
    {
        $barangays = Barangay::all();
        return view('seniors.edit', compact('senior', 'barangays'));
    }

    public function update(Request $request, Senior $senior)
    {
        $request->validate([
            'osca_id'    => 'required|unique:seniors,osca_id,' . $senior->id,
            'name'       => 'required|string|max:255',
            'address'    => 'required|string',
            'age'        => 'required|integer|min:60',
            'birthdate'  => 'nullable|date',
            'sex'        => 'nullable|in:male,female',
            'contact_number' => 'nullable|string|max:20',
            'barangay_id'    => 'nullable|exists:barangays,id',
        ]);

        $senior->update($request->all());
        return redirect()->route('seniors.index')->with('success', 'Senior citizen updated successfully.');
    }

    public function destroy(Senior $senior)
    {
        $senior->delete();
        return redirect()->route('seniors.index')->with('success', 'Senior citizen removed.');
    }
}