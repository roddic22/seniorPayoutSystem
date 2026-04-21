@extends('layouts.app')
@section('content')
<h2>Staff Assignment Details</h2>
<div class="card p-4 mt-3">
    <p><strong>Staff Member:</strong> {{ $staffAssignment->user->name ?? '—' }}</p>
    <p><strong>Cycle:</strong> {{ $staffAssignment->schedule->cycle->cycle_name ?? '—' }}</p>
    <p><strong>Barangay:</strong> {{ $staffAssignment->schedule->barangay->name ?? '—' }}</p>
    <p><strong>Schedule Date:</strong> {{ $staffAssignment->schedule->scheduled_date ?? '—' }}</p>
    <p><strong>Time:</strong>
        {{ $staffAssignment->schedule->time_start ?? '—' }}
        @if($staffAssignment->schedule->time_end)
            - {{ $staffAssignment->schedule->time_end }}
        @endif
    </p>
    <p><strong>Venue:</strong> {{ $staffAssignment->schedule->venue ?? '—' }}</p>
    <p><strong>Counter:</strong> {{ $staffAssignment->counter->counter_number ?? '—' }}</p>
</div>
<a href="{{ route('staff-assignments.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection