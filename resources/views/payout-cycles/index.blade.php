@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Payout Cycles</h2>
    <a href="{{ route('payout-cycles.create') }}" class="btn btn-primary">+ New Cycle</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Cycle Name</th>
            <th>Period Start</th>
            <th>Period End</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($cycles as $cycle)
        <tr>
            <td>{{ $cycle->cycle_name }}</td>
            <td>{{ $cycle->period_start }}</td>
            <td>{{ $cycle->period_end }}</td>
            <td>
                @if($cycle->status === 'active')
                    <span class="badge bg-success">Active</span>
                @elseif($cycle->status === 'draft')
                    <span class="badge bg-secondary">Draft</span>
                @else
                    <span class="badge bg-dark">Completed</span>
                @endif
            </td>
            <td>
                <a href="{{ route('payout-cycles.show', $cycle) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('payout-cycles.edit', $cycle) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('payout-cycles.destroy', $cycle) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this cycle?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">No payout cycles yet.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $cycles->links() }}
@endsection