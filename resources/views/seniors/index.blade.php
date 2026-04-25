@extends('layouts.app')
@section('topbar-title', 'Seniors')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Records</div>
        <h2 class="page-title">Senior citizens</h2>
        <div class="page-sub">Master list of registered senior citizens.</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('seniors.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add senior
        </a>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>OSCA ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Barangay</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($seniors as $senior)
                <tr>
                    <td><span class="text-muted">{{ $senior->osca_id }}</span></td>
                    <td class="fw-semibold">{{ $senior->name }}</td>
                    <td>{{ $senior->age }}</td>
                    <td>{{ $senior->barangay->name ?? '—' }}</td>
                    <td>
                        @if($senior->status === 'active' || $senior->status === 'Active')
                            <span class="pill pill-success">Active</span>
                        @elseif($senior->status === 'inactive' || $senior->status === 'Inactive')
                            <span class="pill pill-muted">Inactive</span>
                        @elseif($senior->status === 'deceased' || $senior->status === 'Deceased')
                            <span class="pill pill-danger">Deceased</span>
                        @else
                            <span class="pill pill-muted">{{ ucfirst($senior->status ?? '—') }}</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="row-actions">
                            <a href="{{ route('seniors.show', $senior) }}" class="row-action view" title="View"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('seniors.edit', $senior) }}" class="row-action edit" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('seniors.destroy', $senior) }}" method="POST"
                                onsubmit="return confirm('Delete this senior record?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="row-action delete" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="table-empty">No seniors registered yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $seniors->links() }}
</div>
@endsection
