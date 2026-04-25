@extends('layouts.app')
@section('topbar-title', 'Counters')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Operations</div>
        <h2 class="page-title">Payout counters</h2>
        <div class="page-sub">Service windows used during disbursement.</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('counters.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add counter
        </a>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Counter no.</th>
                <th>Label</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($counters as $counter)
                <tr>
                    <td class="fw-semibold">{{ $counter->counter_number }}</td>
                    <td>{{ $counter->label ?? '—' }}</td>
                    <td>
                        @if($counter->is_active)
                            <span class="pill pill-success">Active</span>
                        @else
                            <span class="pill pill-muted">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="row-actions">
                            <a href="{{ route('counters.show', $counter) }}" class="row-action view" title="View"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('counters.edit', $counter) }}" class="row-action edit" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('counters.destroy', $counter) }}" method="POST"
                                onsubmit="return confirm('Delete this counter?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="row-action delete" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="table-empty">No counters configured yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $counters->links() }}
</div>
@endsection
