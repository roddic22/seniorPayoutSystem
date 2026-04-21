@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Payout Schedules</h2>
    <a href="{{ route('payout-schedules.create') }}" class="btn btn-primary">+ New Schedule</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Cycle</th>
            <th>Barangay</th>
            <th>Date</th>
            <th>Time</th>
            <th>Venue</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($schedules as $schedule)
        <tr>
            <td>{{ $schedule->cycle->cycle_name ?? '—' }}</td>
            <td>{{ $schedule->barangay->name ?? '—' }}</td>
            <td>{{ $schedule->scheduled_date }}</td>
            <td>
                {{ $schedule->time_start ?? '—' }}
                @if($schedule->time_end) - {{ $schedule->time_end }} @endif
            </td>
            <td>{{ $schedule->venue ?? '—' }}</td>
            <td>
                <a href="{{ route('payout-schedules.show', $schedule) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('payout-schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('payout-schedules.destroy', $schedule) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this schedule?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">No schedules yet.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $schedules->links() }}
@endsection