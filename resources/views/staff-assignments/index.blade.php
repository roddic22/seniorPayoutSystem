@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Staff Assignments</h2>
    <a href="{{ route('staff-assignments.create') }}" class="btn btn-primary">+ Assign Staff</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Staff Name</th>
            <th>Cycle</th>
            <th>Barangay</th>
            <th>Schedule Date</th>
            <th>Counter</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($assignments as $assignment)
        <tr>
            <td>{{ $assignment->user->name ?? '—' }}</td>
            <td>{{ $assignment->schedule->cycle->cycle_name ?? '—' }}</td>
            <td>{{ $assignment->schedule->barangay->name ?? '—' }}</td>
            <td>{{ $assignment->schedule->scheduled_date ?? '—' }}</td>
            <td>{{ $assignment->counter->counter_number ?? '—' }}</td>
            <td>
                <a href="{{ route('staff-assignments.show', $assignment) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('staff-assignments.edit', $assignment) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('staff-assignments.destroy', $assignment) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Remove this assignment?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Remove</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">No staff assigned yet.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $assignments->links() }}
@endsection