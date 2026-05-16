@extends('layouts.app')
@section('topbar-title', 'Staff assignments')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Operations</div>
        <h2 class="page-title">Staff assignments</h2>
        <div class="page-sub">Counter assignments per payout schedule.</div>
    </div>
    <div class="page-actions">
        <form
            method="GET"
            action="{{ route('staff-assignments.index') }}"
            class="expanding-search {{ $search !== '' ? 'is-open' : '' }}"
            data-clear-url="{{ route('staff-assignments.index') }}"
            data-expanding-search
        >
            <input
                type="search"
                name="search"
                class="expanding-search-input"
                value="{{ $search }}"
                placeholder="Search"
                aria-label="Search staff assignments"
                data-expanding-search-input
            >
            <button type="submit" class="expanding-search-btn" aria-label="Search" data-expanding-search-button>
                <i class="bi bi-search"></i>
            </button>
            <button type="button" class="expanding-search-close" aria-label="Close search" data-expanding-search-close>
                <i class="bi bi-x-lg"></i>
            </button>
        </form>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('staff-assignments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Assign staff
        </a>
        @endif
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Staff name</th>
                <th>Cycle</th>
                <th>Barangay</th>
                <th>Schedule date</th>
                <th>Counter</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assignments as $assignment)
                <tr>
                    <td class="fw-semibold">{{ $assignment->user->name ?? '—' }}</td>
                    <td class="text-muted">{{ $assignment->schedule->cycle->cycle_name ?? '—' }}</td>
                    <td>{{ $assignment->schedule->barangay->name ?? '—' }}</td>
                    <td>{{ $assignment->schedule->scheduled_date ?? '—' }}</td>
                    <td>{{ $assignment->counter->counter_number ?? '—' }}</td>
                    <td class="text-end">
                        <div class="row-actions">
                            <a href="{{ route('staff-assignments.show', $assignment) }}" class="row-action view" title="View"><i class="bi bi-eye"></i></a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('staff-assignments.edit', $assignment) }}" class="row-action edit" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('staff-assignments.destroy', $assignment) }}" method="POST"
                                onsubmit="return confirm('Remove this assignment?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="row-action delete" title="Remove"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="table-empty">
                        {{ $search !== '' ? 'No staff assignments match your search.' : 'No staff assignments yet.' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $assignments->links() }}
</div>
@endsection
