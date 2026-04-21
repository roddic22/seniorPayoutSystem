@extends('layouts.app')
@section('content')
<h2>Document Requirement Details</h2>
<div class="card p-4 mt-3">
    <p><strong>Cycle:</strong> {{ $documentRequirement->cycle->cycle_name ?? '—' }}</p>
    <p><strong>Document Name:</strong> {{ $documentRequirement->document_name }}</p>
    <p><strong>Description:</strong> {{ $documentRequirement->description ?? '—' }}</p>
    <p><strong>Mandatory:</strong>
        @if($documentRequirement->is_mandatory)
            <span class="badge bg-danger">Mandatory</span>
        @else
            <span class="badge bg-secondary">Optional</span>
        @endif
    </p>
</div>
<a href="{{ route('document-requirements.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection