@extends('layouts.app')
@section('topbar-title', 'Requirements')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Operations</div>
        <h2 class="page-title">Document requirements</h2>
        <div class="page-sub">Required documents per payout cycle.</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('document-requirements.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add requirement
        </a>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Cycle</th>
                <th>Document</th>
                <th>Description</th>
                <th>Mandatory</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requirements as $req)
                <tr>
                    <td class="text-muted">{{ $req->cycle->cycle_name ?? '—' }}</td>
                    <td class="fw-semibold">{{ $req->document_name }}</td>
                    <td class="text-muted">{{ Str::limit($req->description, 60) ?? '—' }}</td>
                    <td>
                        @if($req->is_mandatory)
                            <span class="pill pill-danger">Required</span>
                        @else
                            <span class="pill pill-muted">Optional</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="row-actions">
                            <a href="{{ route('document-requirements.show', $req) }}" class="row-action view" title="View"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('document-requirements.edit', $req) }}" class="row-action edit" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('document-requirements.destroy', $req) }}" method="POST"
                                onsubmit="return confirm('Delete this requirement?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="row-action delete" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="table-empty">No document requirements set yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $requirements->links() }}
</div>
@endsection
