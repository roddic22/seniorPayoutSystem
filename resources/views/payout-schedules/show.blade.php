@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Schedule Details</h2>
    <a href="{{ route('payout-schedules.index') }}" class="btn btn-secondary">Back</a>
</div>
<div class="card p-4 mb-4">
    <p><strong>Cycle:</strong> {{ $payoutSchedule->cycle->cycle_name ?? '—' }}</p>
    <p><strong>Barangay:</strong> {{ $payoutSchedule->barangay->name ?? '—' }}</p>
    <p><strong>Date:</strong> {{ $payoutSchedule->scheduled_date }}</p>
    <p><strong>Time:</strong>
        {{ $payoutSchedule->time_start ?? '—' }}
        @if($payoutSchedule->time_end) - {{ $payoutSchedule->time_end }} @endif
    </p>
    <p><strong>Venue:</strong> {{ $payoutSchedule->venue ?? '—' }}</p>
</div>

<h5>Assigned Staff</h5>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr><th>Staff Name</th><th>Counter</th></tr>
    </thead>
    <tbody>
        @forelse($payoutSchedule->staffAssignments as $assignment)
        <tr>
            <td>{{ $assignment->user->name ?? '—' }}</td>
            <td>{{ $assignment->counter->counter_number ?? '—' }}</td>
        </tr>
        @empty
        <tr><td colspan="2" class="text-center">No staff assigned yet.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection