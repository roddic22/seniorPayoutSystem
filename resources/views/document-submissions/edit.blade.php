@extends('layouts.app')
@section('topbar-title', 'Edit Submission')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Document Submissions</div>
        <h2 class="page-title">Edit document submission</h2>
    </div>
    <div class="page-actions">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<div class="surface" style="max-width:560px">
    <form action="{{ route('document-submissions.update', $documentSubmission) }}"
        method="POST">
        @csrf @method('PUT')
        <div class="form-section">
            <div class="mb-3">
                <label class="form-label">Transaction</label>
                <select name="transaction_id" class="form-select" required>
                    @foreach($transactions as $tx)
                        <option value="{{ $tx->id }}"
                            {{ $documentSubmission->transaction_id == $tx->id ? 'selected' : '' }}>
                            #{{ $tx->id }} — {{ $tx->senior->name ?? '—' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Document Requirement</label>
                <select name="requirement_id" class="form-select" required>
                    @foreach($requirements as $req)
                        <option value="{{ $req->id }}"
                            {{ $documentSubmission->requirement_id == $req->id ? 'selected' : '' }}>
                            {{ $req->document_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_submitted"
                    class="form-check-input" id="is_submitted"
                    {{ $documentSubmission->is_submitted ? 'checked' : '' }}>
                <label class="form-check-label" for="is_submitted">Document was submitted</label>
            </div>
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">
                    {{ $documentSubmission->notes }}
                </textarea>
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i> Update
            </button>
        </div>
    </form>
</div>
@endsection