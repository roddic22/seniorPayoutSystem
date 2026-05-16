<?php
namespace App\Http\Controllers;

use App\Models\DocumentSubmission;
use App\Models\PayoutTransaction;
use App\Models\DocumentRequirement;
use Illuminate\Http\Request;

class DocumentSubmissionController extends Controller
{
    public function index()
    {
        $submissions = DocumentSubmission::with([
            'transaction.senior', 'requirement'
        ])->oldest()->paginate(10);
        return view('document-submissions.index', compact('submissions'));
    }

    public function create(Request $request)
    {
        $transactions = PayoutTransaction::with(['senior', 'cycle'])
            ->when($request->senior_id, function ($query) use ($request) {
                $query->where('senior_id', $request->senior_id);
            })
            ->oldest()
            ->get();
        $requirements  = DocumentRequirement::all();
        $selectedTx    = $request->transaction_id;
        $selectedSr    = $request->senior_id;
        return view('document-submissions.create', compact(
            'transactions', 'requirements', 'selectedTx', 'selectedSr'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id'  => 'required|exists:payout_transactions,id',
            'requirement_id'  => 'required|exists:document_requirements,id',
            'is_submitted'    => 'nullable|boolean',
            'notes'           => 'nullable|string|max:255',
            'source_senior_id' => 'nullable|exists:seniors,id',
        ]);

        $exists = DocumentSubmission::where('transaction_id', $request->transaction_id)
            ->where('requirement_id', $request->requirement_id)
            ->exists();

        if ($exists) {
            return back()->withInput()
                ->with('error', 'This document has already been recorded for this transaction.');
        }

        DocumentSubmission::create([
            'transaction_id' => $request->transaction_id,
            'requirement_id' => $request->requirement_id,
            'is_submitted'   => $request->has('is_submitted') ? 1 : 0,
            'notes'          => $request->notes,
        ]);

        if ($request->filled('source_senior_id')) {
            return redirect()->route('seniors.show', $request->source_senior_id)
                ->with('success', 'Document submission recorded.');
        }

        return redirect()->route('payout-transactions.show', $request->transaction_id)
            ->with('success', 'Document submission recorded.');
    }

    public function show(DocumentSubmission $documentSubmission)
    {
        $documentSubmission->load(['transaction.senior', 'requirement']);
        return view('document-submissions.show', compact('documentSubmission'));
    }

    public function edit(DocumentSubmission $documentSubmission)
    {
        $transactions = PayoutTransaction::with(['senior', 'cycle'])->oldest()->get();
        $requirements = DocumentRequirement::all();
        return view('document-submissions.edit', compact(
            'documentSubmission', 'transactions', 'requirements'
        ));
    }

    public function update(Request $request, DocumentSubmission $documentSubmission)
    {
        $request->validate([
            'transaction_id' => 'required|exists:payout_transactions,id',
            'requirement_id' => 'required|exists:document_requirements,id',
            'is_submitted'   => 'nullable|boolean',
            'notes'          => 'nullable|string|max:255',
        ]);

        $documentSubmission->update([
            'transaction_id' => $request->transaction_id,
            'requirement_id' => $request->requirement_id,
            'is_submitted'   => $request->has('is_submitted') ? 1 : 0,
            'notes'          => $request->notes,
        ]);

        return redirect()->route('payout-transactions.show', $documentSubmission->transaction_id)
            ->with('success', 'Document submission updated.');
    }

    public function destroy(DocumentSubmission $documentSubmission)
    {
        $txId = $documentSubmission->transaction_id;
        $documentSubmission->delete();
        return redirect()->route('payout-transactions.show', $txId)
            ->with('success', 'Document submission removed.');
    }
}
