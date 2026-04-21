@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Document Requirements</h2>
    <a href="{{ route('document-requirements.create') }}" class="btn btn-primary">+ Add Requirement</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Cycle</th>
            <th>Document Name</th>
            <th>Description</th>
            <th>Mandatory</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($requirements as $req)
        <tr>
            <td>{{ $req->cycle->cycle_name ?? '—' }}</td>
            <td>{{ $req->document_name }}</td>
            <td>{{ $req->description ?? '—' }}</td>
            <td>
                @if($req->is_mandatory)
                    <span class="badge bg-danger">Mandatory</span>
                @else
                    <span class="badge bg-secondary">Optional</span>
                @endif
            </td>
            <td>
                <a href="{{ route('document-requirements.show', $req) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('document-requirements.edit', $req) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('document-requirements.destroy', $req) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this requirement?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">No document requirements yet.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $requirements->links() }}
@endsection