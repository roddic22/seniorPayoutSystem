@extends('layouts.app')
@section('topbar-title', 'Submission details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">
            <a href="{{ route('document-submissions.index') }}" class="text-muted text-decoration-none">Document submissions</a> / Details
        </div>
        <h2 class="page-title">{{ $documentSubmission->requirement->document_name ?? 'Document submission' }}</h2>
        <div class="page-sub">{{ $documentSubmission->transaction->senior->name ?? '-' }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <a href="{{ route('document-submissions.edit', $documentSubmission) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Submission information</h5>
        @if($documentSubmission->is_submitted)
            <span class="pill pill-success">Submitted</span>
        @else
            <span class="pill pill-danger">Missing</span>
        @endif
    </div>
    <div class="surface-body">
        <dl class="deflist">
            <dt>Transaction</dt><dd>#{{ $documentSubmission->transaction_id }}</dd>
            <dt>Senior</dt><dd>{{ $documentSubmission->transaction->senior->name ?? '-' }}</dd>
            <dt>Document</dt><dd>{{ $documentSubmission->requirement->document_name ?? '-' }}</dd>
            <dt>Notes</dt><dd>{{ $documentSubmission->notes ?? '-' }}</dd>
        </dl>
    </div>
</div>
@endsection
