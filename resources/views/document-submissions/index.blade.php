@extends('layouts.app')
@section('topbar-title', 'Document submissions')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Operations</div>
        <h2 class="page-title">Document submissions</h2>
        <div class="page-sub">Track submitted requirements for payout transactions.</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('document-submissions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add submission
        </a>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Transaction</th>
                <th>Senior</th>
                <th>Document</th>
                <th>Submitted</th>
                <th>Notes</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $submission)
                <tr>
                    <td class="text-muted">#{{ $submission->transaction_id }}</td>
                    <td class="fw-semibold">{{ $submission->transaction->senior->name ?? '-' }}</td>
                    <td>{{ $submission->requirement->document_name ?? '-' }}</td>
                    <td>
                        @if($submission->is_submitted)
                            <span class="pill pill-success">Submitted</span>
                        @else
                            <span class="pill pill-danger">Missing</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $submission->notes ?? '-' }}</td>
                    <td class="text-end">
                        <div class="row-actions">
                            <a href="{{ route('document-submissions.show', $submission) }}" class="row-action view" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('document-submissions.edit', $submission) }}" class="row-action edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <form action="{{ route('document-submissions.destroy', $submission) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Remove this submission?')">
                                @csrf @method('DELETE')
                                <button class="row-action delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="table-empty">No document submissions recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $submissions->links() }}
</div>
@endsection
