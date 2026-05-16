<?php

namespace App\Http\Controllers;

use App\Models\Senior;
use App\Models\Barangay;
use Illuminate\Http\Request;

class SeniorController extends Controller
{
    public function index(Request $request)
    {
        $selectedBarangayId = $request->integer('barangay_id') ?: null;
        $search = trim((string) $request->query('search', ''));
        $selectedBarangay = $selectedBarangayId
            ? Barangay::find($selectedBarangayId)
            : null;

        $barangays = Barangay::withCount('seniors')
            ->orderBy('name')
            ->get();

        $seniorStats = [
            'total' => Senior::count(),
            'active' => Senior::whereIn('status', ['active', 'Active'])->count(),
            'inactive' => Senior::whereIn('status', ['inactive', 'Inactive'])->count(),
            'deceased' => Senior::whereIn('status', ['deceased', 'Deceased'])->count(),
        ];

        $seniors = null;

        if ($selectedBarangay || $search !== '') {
            $seniors = Senior::with('barangay')
                ->when($selectedBarangay, function ($query) use ($selectedBarangay) {
                    $query->where('barangay_id', $selectedBarangay->id);
                })
                ->when($search !== '', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view('seniors.index', compact(
            'seniors',
            'seniorStats',
            'barangays',
            'selectedBarangay',
            'selectedBarangayId',
            'search'
        ));
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
            'status'     => 'nullable|in:active,inactive,deceased',
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
            'osca_id'        => 'required|string|max:50|unique:seniors,osca_id,' . $senior->id,
            'name'           => 'required|string|max:255',
            'address'        => 'required|string|max:500',
            'age'            => 'required|integer|min:60|max:120',
            'birthdate'      => 'nullable|date|before:today',
            'sex'            => 'nullable|in:male,female',
            'contact_number' => 'nullable|string|max:20',
            'barangay_id'    => 'nullable|exists:barangays,id',
            'status'         => 'required|in:active,inactive,deceased',
        ]);

        $senior->update([
            'osca_id'        => $request->osca_id,
            'name'           => $request->name,
            'address'        => $request->address,
            'age'            => $request->age,
            'birthdate'      => $request->birthdate ?? null,
            'sex'            => $request->sex ?? null,
            'contact_number' => $request->contact_number ?? null,
            'barangay_id'    => $request->barangay_id ?? null,
            'status'         => $request->status,
        ]);

        return redirect()->route('seniors.show', $senior)
            ->with('success', 'Senior record updated successfully.');
    }

    public function destroy(Senior $senior)
    {
        $senior->delete();
        return redirect()->route('seniors.index')->with('success', 'Senior citizen removed.');
    }
}
