@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Payout Counters</h2>
    <a href="{{ route('counters.create') }}" class="btn btn-primary">+ Add Counter</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Counter No.</th>
            <th>Label</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($counters as $counter)
        <tr>
            <td>{{ $counter->counter_number }}</td>
            <td>{{ $counter->label ?? '—' }}</td>
            <td>
                @if($counter->is_active)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-secondary">Inactive</span>
                @endif
            </td>
            <td>
                <a href="{{ route('counters.show', $counter) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('counters.edit', $counter) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('counters.destroy', $counter) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this counter?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center">No counters yet.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $counters->links() }}
@endsection