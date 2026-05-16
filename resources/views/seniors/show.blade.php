@extends('layouts.app')
@section('topbar-title', 'Senior details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('seniors.index') }}" class="text-muted text-decoration-none">Seniors</a> / {{ $senior->osca_id }}</div>
        <h2 class="page-title">{{ $senior->name }}</h2>
        <div class="page-sub">OSCA ID {{ $senior->osca_id }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('seniors.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <a href="{{ route('seniors.edit', $senior) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Profile</h5>
        @if($senior->status === 'active' || $senior->status === 'Active')
            <span class="pill pill-success">Active</span>
        @elseif($senior->status === 'inactive' || $senior->status === 'Inactive')
            <span class="pill pill-muted">Inactive</span>
        @elseif($senior->status === 'deceased' || $senior->status === 'Deceased')
            <span class="pill pill-danger">Deceased</span>
        @else
            <span class="pill pill-muted">{{ ucfirst($senior->status ?? '-') }}</span>
        @endif
    </div>
    <div class="surface-body">
        <dl class="deflist">
            <dt>OSCA ID</dt><dd>{{ $senior->osca_id }}</dd>
            <dt>Full name</dt><dd>{{ $senior->name }}</dd>
            <dt>Age</dt><dd>{{ $senior->age }}</dd>
            <dt>Birthdate</dt><dd>{{ $senior->birthdate ?? '-' }}</dd>
            <dt>Sex</dt><dd>{{ $senior->sex ? ucfirst($senior->sex) : '-' }}</dd>
            <dt>Contact</dt><dd>{{ $senior->contact_number ?? '-' }}</dd>
            <dt>Address</dt><dd>{{ $senior->address }}</dd>
            <dt>Barangay</dt><dd>{{ $senior->barangay->name ?? '-' }}</dd>
            <dt>Documents submitted</dt>
            <dd>
                @if($submittedDocuments->count())
                    <span class="pill pill-success">{{ $submittedDocuments->count() }} submitted</span>
                @else
                    <span class="pill pill-muted">None submitted</span>
                @endif
            </dd>
            <dt>Missing documents</dt>
            <dd>
                @if($missingDocuments->count())
                    <span class="pill pill-danger">{{ $missingDocuments->count() }} missing</span>
                @else
                    <span class="pill pill-success">None recorded</span>
                @endif
            </dd>
            <dt>Latest document</dt>
            <dd>
                @if($latestDocumentSubmission)
                    {{ $latestDocumentSubmission->requirement->document_name ?? '-' }}
                    <span class="text-muted">
                        ({{ optional($latestDocumentSubmission->updated_at)->format('M d, Y') }})
                    </span>
                @else
                    -
                @endif
            </dd>
        </dl>
    </div>
</div>

<div class="surface mt-3">
    <div class="surface-head">
        <h5><i class="bi bi-file-earmark-check me-2"></i>Document Submissions</h5>
        @if(auth()->user()->role !== 'staff')
        <a href="{{ route('document-submissions.create') }}?senior_id={{ $senior->id }}"
            class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Submission
        </a>
        @endif
    </div>
    <div class="surface-body p-0">
        <table class="table">
            <thead>
                <tr>
                    <th>Transaction</th>
                    <th>Document</th>
                    <th>Submitted</th>
                    <th>Notes</th>
                    @if(auth()->user()->role !== 'staff')
                    <th class="text-end">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($documentSubmissions as $sub)
                <tr>
                    <td>{{ $sub->transaction->cycle->cycle_name ?? '—' }}</td>
                    <td>{{ $sub->requirement->document_name ?? '—' }}</td>
                    <td>
                        @if($sub->is_submitted)
                            <span class="pill pill-success">Yes</span>
                        @else
                            <span class="pill pill-danger">No</span>
                        @endif
                    </td>
                    <td>{{ $sub->notes ?? '—' }}</td>
                    @if(auth()->user()->role !== 'staff')
                    <td class="text-end">
                        <a href="{{ route('document-submissions.edit', $sub) }}"
                            class="row-action edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role !== 'staff' ? 5 : 4 }}" class="table-empty">
                        No document submissions yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
