@extends('layouts.app')
@section('topbar-title', 'Add Document Submission')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Document Submissions</div>
        <h2 class="page-title">Record document submission</h2>
    </div>
    <div class="page-actions">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

@if(session('error'))
<div class="alert alert-danger mb-3">{{ session('error') }}</div>
@endif

<div class="surface" style="max-width:560px">
    <form action="{{ route('document-submissions.store') }}" method="POST">
        @csrf
        <div class="form-section">
            <div class="mb-3">
                <label class="form-label">Transaction</label>
                <select name="transaction_id" class="form-select" required>
                    <option value="">-- Select Transaction --</option>
                    @foreach($transactions as $tx)
                        <option value="{{ $tx->id }}"
                            {{ $selectedTx == $tx->id ? 'selected' : '' }}>
                            #{{ $tx->id }} — {{ $tx->senior->name ?? '—' }}
                            ({{ $tx->cycle->cycle_name ?? '—' }})
                        </option>
                    @endforeach
                </select>
                @error('transaction_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Document Requirement</label>
                <select name="requirement_id" class="form-select" required>
                    <option value="">-- Select Document --</option>
                    @foreach($requirements as $req)
                        <option value="{{ $req->id }}">{{ $req->document_name }}</option>
                    @endforeach
                </select>
                @error('requirement_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_submitted"
                    class="form-check-input" id="is_submitted" checked>
                <label class="form-check-label" for="is_submitted">Document was submitted</label>
            </div>
            <div class="mb-3">
                <label class="form-label">Notes <span class="text-muted">(optional)</span></label>
                <textarea name="notes" class="form-control" rows="2"
                    placeholder="e.g. photocopy accepted, original presented"></textarea>
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i> Save Submission
            </button>
        </div>
    </form>
</div>
@endsection