@extends('layouts.app')
@section('topbar-title', 'Requirement details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('document-requirements.index') }}" class="text-muted text-decoration-none">Requirements</a> / Details</div>
        <h2 class="page-title">{{ $documentRequirement->document_name }}</h2>
        <div class="page-sub">{{ $documentRequirement->cycle->cycle_name ?? '—' }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('document-requirements.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <a href="{{ route('document-requirements.edit', $documentRequirement) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Requirement information</h5>
        @if($documentRequirement->is_mandatory)
            <span class="pill pill-danger">Required</span>
        @else
            <span class="pill pill-muted">Optional</span>
        @endif
    </div>
    <div class="surface-body">
        <dl class="deflist">
            <dt>Cycle</dt><dd>{{ $documentRequirement->cycle->cycle_name ?? '—' }}</dd>
            <dt>Document name</dt><dd>{{ $documentRequirement->document_name }}</dd>
            <dt>Description</dt><dd>{{ $documentRequirement->description ?? '—' }}</dd>
            <dt>Mandatory</dt><dd>{{ $documentRequirement->is_mandatory ? 'Yes' : 'No' }}</dd>
        </dl>
    </div>
</div>
@endsection
