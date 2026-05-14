@extends('layouts.app')
@section('topbar-title', 'Barangays')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Records</div>
        <h2 class="page-title">Barangays</h2>
        <div class="page-sub">Service-area barangays and senior counts.</div>
    </div>
    <div class="page-actions">
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('barangays.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add barangay
        </a>
        @endif
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>City</th>
                <th class="text-end">Seniors</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangays as $barangay)
                <tr>
                    <td class="text-muted">{{ $barangay->id }}</td>
                    <td class="fw-semibold">{{ $barangay->name }}</td>
                    <td>{{ $barangay->city }}</td>
                    <td class="text-end">
                        <span class="pill pill-muted">{{ $barangay->seniors()->count() }}</span>
                    </td>
                    <td class="text-end">
                        <div class="row-actions">
                            <a href="{{ route('barangays.show', $barangay) }}"
                                class="row-action view" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('barangays.edit', $barangay) }}"
                                class="row-action edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('barangays.destroy', $barangay) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this barangay?')"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="row-action delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="table-empty">No barangays added yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $barangays->links() }}
</div>
@endsection