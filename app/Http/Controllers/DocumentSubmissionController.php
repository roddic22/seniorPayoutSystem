<?php
namespace App\Http\Controllers;

use App\Models\DocumentSubmission;
use App\Models\PayoutTransaction;
use App\Models\DocumentRequirement;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $selectedBarangayId = $request->integer('barangay_id') ?: null;
        $selectedBarangay = $selectedBarangayId ? Barangay::find($selectedBarangayId) : null;

        $barangays = Barangay::select(
                'barangays.*',
                DB::raw('COUNT(document_submissions.id) as submissions_count')
            )
            ->leftJoin('seniors', 'seniors.barangay_id', '=', 'barangays.id')
            ->leftJoin('payout_transactions', 'payout_transactions.senior_id', '=', 'seniors.id')
            ->leftJoin('document_submissions', 'document_submissions.transaction_id', '=', 'payout_transactions.id')
            ->groupBy('barangays.id', 'barangays.name', 'barangays.city', 'barangays.created_at', 'barangays.updated_at')
            ->orderBy('barangays.name')
            ->get();

        $submissions = DocumentSubmission::with([
                'transaction.senior.barangay', 'transaction.cycle', 'requirement'
            ])
            ->when($selectedBarangay, function ($query) use ($selectedBarangay) {
                $query->whereHas('transaction.senior', function ($query) use ($selectedBarangay) {
                    $query->where('barangay_id', $selectedBarangay->id);
                });
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('notes', 'like', '%' . $search . '%')
                        ->orWhereHas('transaction.senior', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%')
                                ->orWhere('osca_id', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('transaction.senior.barangay', function ($query) use ($search) {
                            $query->where('name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('transaction.cycle', function ($query) use ($search) {
                            $query->where('cycle_name', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('requirement', function ($query) use ($search) {
                            $query->where('document_name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->oldest()
            ->paginate(10)
            ->withQueryString();

        return view('document-submissions.index', compact(
            'submissions',
            'barangays',
            'selectedBarangay',
            'selectedBarangayId',
            'search'
        ));
    }

    public function create(Request $request)
    {
        $transactions = PayoutTransaction::with(['senior', 'cycle'])
            ->when($request->senior_id, function ($query) use ($request) {
                $query->where('senior_id', $request->senior_id);
            })
            ->oldest()
            ->get();
        $requirements = DocumentRequirement::orderByDesc('is_mandatory')
            ->orderBy('document_name')
            ->get();
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
            'requirement_ids' => 'required|array|min:1',
            'requirement_ids.*' => 'exists:document_requirements,id',
            'is_submitted'    => 'nullable|boolean',
            'notes'           => 'nullable|string|max:255',
            'source_senior_id' => 'nullable|exists:seniors,id',
        ]);

        $requirementIds = collect($request->input('requirement_ids', []))
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values();

        $existingRequirementIds = DocumentSubmission::where('transaction_id', $request->transaction_id)
            ->whereIn('requirement_id', $requirementIds)
            ->pluck('requirement_id')
            ->map(fn($id) => (int) $id);

        $newRequirementIds = $requirementIds->diff($existingRequirementIds);

        if ($newRequirementIds->isEmpty()) {
            return back()->withInput()
                ->with('error', 'The selected documents have already been recorded for this transaction.');
        }

        $newRequirementIds->each(function ($requirementId) use ($request) {
            DocumentSubmission::create([
                'transaction_id' => $request->transaction_id,
                'requirement_id' => $requirementId,
                'is_submitted'   => $request->has('is_submitted') ? 1 : 0,
                'notes'          => $request->notes,
            ]);
        });

        $message = $newRequirementIds->count() === 1
            ? 'Document submission recorded.'
            : $newRequirementIds->count() . ' document submissions recorded.';

        if ($request->filled('source_senior_id')) {
            return redirect()->to(route('seniors.show', $request->source_senior_id) . '#senior-submissions')
                ->with('success', $message);
        }

        return redirect()->to(route('payout-transactions.show', $request->transaction_id) . '#transaction-submissions')
            ->with('success', $message);
    }

    public function show(DocumentSubmission $documentSubmission)
    {
        $documentSubmission->load(['transaction.senior', 'requirement']);
        return view('document-submissions.show', compact('documentSubmission'));
    }

    public function edit(DocumentSubmission $documentSubmission)
    {
        $transactions = PayoutTransaction::with(['senior', 'cycle'])->oldest()->get();
        $requirements = DocumentRequirement::orderByDesc('is_mandatory')
            ->orderBy('document_name')
            ->get();
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

        return redirect()->to(route('payout-transactions.show', $documentSubmission->transaction_id) . '#transaction-submissions')
            ->with('success', 'Document submission updated.');
    }

    public function destroy(DocumentSubmission $documentSubmission)
    {
        $txId = $documentSubmission->transaction_id;
        $documentSubmission->delete();
        return redirect()->to(route('payout-transactions.show', $txId) . '#transaction-submissions')
            ->with('success', 'Document submission removed.');
    }
}
