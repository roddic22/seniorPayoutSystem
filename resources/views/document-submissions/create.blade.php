@extends('layouts.app')
@section('topbar-title', 'Submit Document')

@push('head')
<style>
    .document-choice-list {
        display: grid;
        gap: .55rem;
    }

    .document-choice {
        display: flex;
        align-items: flex-start;
        gap: .65rem;
        padding: .75rem .85rem;
        border: 1px solid var(--c-line);
        border-radius: 8px;
        background: #fff;
    }

    .document-choice.required {
        border-color: #bfdbfe;
        background: var(--c-primary-50);
    }

    .document-choice .form-check-input {
        margin-top: .18rem;
    }

    .document-choice-name {
        display: block;
        font-weight: 600;
        color: var(--c-ink);
        line-height: 1.25;
    }

    .document-choice-meta {
        display: flex;
        gap: .35rem;
        align-items: center;
        flex-wrap: wrap;
        margin-top: .2rem;
    }
</style>
@endpush

@section('content')
@php
    $backUrl = $selectedSr
        ? route('seniors.show', $selectedSr)
        : ($selectedTx ? route('payout-transactions.show', $selectedTx) : route('document-submissions.index'));
@endphp

<div class="page-head">
    <div>
        <div class="page-eyebrow">Submit Documents</div>
        <h2 class="page-title">Submit document</h2>
    </div>
    <div class="page-actions">
        <a href="{{ $backUrl }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

@if(session('error'))
<div class="alert alert-danger mb-3">{{ session('error') }}</div>
@endif

<div class="surface" style="max-width:760px">
    <form action="{{ route('document-submissions.store') }}" method="POST">
        @csrf
        @if($selectedSr)
            <input type="hidden" name="source_senior_id" value="{{ $selectedSr }}">
        @endif
        @if(!$selectedSr && !$selectedTx)
            <input type="hidden" name="source_context" value="document-submissions">
        @endif
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
                <label class="form-label">Document Requirements</label>
                <div class="document-choice-list">
                    @foreach($requirements as $req)
                        <label class="document-choice {{ $req->is_mandatory ? 'required' : '' }}" for="requirement_{{ $req->id }}">
                            <input
                                type="checkbox"
                                name="requirement_ids[]"
                                value="{{ $req->id }}"
                                class="form-check-input"
                                id="requirement_{{ $req->id }}"
                                {{ in_array($req->id, old('requirement_ids', [])) ? 'checked' : '' }}
                            >
                            <span>
                                <span class="document-choice-name">{{ $req->document_name }}</span>
                                <span class="document-choice-meta">
                                    @if($req->is_mandatory)
                                        <span class="pill pill-warning">Required</span>
                                    @else
                                        <span class="pill pill-muted">Optional</span>
                                    @endif
                                    @if($req->description)
                                        <span class="text-muted" style="font-size:.75rem">{{ $req->description }}</span>
                                    @endif
                                </span>
                            </span>
                        </label>
                    @endforeach
                </div>
                <div class="form-hint">Required documents are listed first. Select all documents submitted for this transaction.</div>
                @error('requirement_ids')<div class="form-error">{{ $message }}</div>@enderror
                @error('requirement_ids.*')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_submitted" value="1"
                    class="form-check-input" id="is_submitted" checked>
                <label class="form-check-label" for="is_submitted">Document was submitted</label>
                @error('is_submitted')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Notes <span class="text-muted">(optional)</span></label>
                <textarea name="notes" class="form-control" rows="2"
                    placeholder="e.g. photocopy accepted, original presented"></textarea>
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ $backUrl }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i> Save Submission
            </button>
        </div>
    </form>
</div>
@endsection
