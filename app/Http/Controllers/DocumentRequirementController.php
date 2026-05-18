<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequirement;
use App\Models\PayoutCycle;
use Illuminate\Http\Request;

class DocumentRequirementController extends Controller
{
    public function index()
    {
        $requirements = DocumentRequirement::with('cycle')->oldest()->paginate(10);
        return view('document-requirements.index', compact('requirements'));
    }

    public function create()
    {
        $cycles = PayoutCycle::all();
        return view('document-requirements.create', compact('cycles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cycle_id'      => 'required|exists:payout_cycles,id',
            'document_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'is_mandatory'  => 'nullable|boolean',
        ]);

        DocumentRequirement::create([
            'cycle_id'      => $request->cycle_id,
            'document_name' => $request->document_name,
            'description'   => $request->description,
            'is_mandatory'  => $request->has('is_mandatory') ? 1 : 0,
        ]);

        return redirect()->route('document-requirements.index')
            ->with('success', 'Document requirement added.');
    }

    public function show(DocumentRequirement $documentRequirement)
    {
        return view('document-requirements.show', compact('documentRequirement'));
    }

    public function edit(DocumentRequirement $documentRequirement)
    {
        $cycles = PayoutCycle::all();
        return view('document-requirements.edit', compact('documentRequirement', 'cycles'));
    }

    public function update(Request $request, DocumentRequirement $documentRequirement)
    {
        $request->validate([
            'cycle_id'      => 'required|exists:payout_cycles,id',
            'document_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'is_mandatory'  => 'nullable|boolean',
        ]);

        $documentRequirement->update([
            'cycle_id'      => $request->cycle_id,
            'document_name' => $request->document_name,
            'description'   => $request->description,
            'is_mandatory'  => $request->has('is_mandatory') ? 1 : 0,
        ]);

        return redirect()->route('document-requirements.index')
            ->with('success', 'Document requirement updated.');
    }

    public function destroy(DocumentRequirement $documentRequirement)
    {
        $documentRequirement->delete();
        return redirect()->route('document-requirements.index')
            ->with('success', 'Document requirement deleted.');
    }
}
