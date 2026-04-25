@extends('layouts.app')
@section('topbar-title', 'Schedule details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('payout-schedules.index') }}" class="text-muted text-decoration-none">Schedules</a> / Details</div>
        <h2 class="page-title">{{ $payoutSchedule->barangay->name ?? 'Schedule' }}</h2>
        <div class="page-sub">{{ $payoutSchedule->scheduled_date }} · {{ $payoutSchedule->cycle->cycle_name ?? '—' }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('payout-schedules.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <a href="{{ route('payout-schedules.edit', $payoutSchedule) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="surface mb-3">
    <div class="surface-head">
        <h5>Schedule information</h5>
    </div>
    <div class="surface-body">
        <dl class="deflist">
            <dt>Cycle</dt><dd>{{ $payoutSchedule->cycle->cycle_name ?? '—' }}</dd>
            <dt>Barangay</dt><dd>{{ $payoutSchedule->barangay->name ?? '—' }}</dd>
            <dt>Date</dt><dd>{{ $payoutSchedule->scheduled_date }}</dd>
            <dt>Time</dt><dd>{{ $payoutSchedule->time_start ?? '—' }}@if($payoutSchedule->time_end) — {{ $payoutSchedule->time_end }}@endif</dd>
            <dt>Venue</dt><dd>{{ $payoutSchedule->venue ?? '—' }}</dd>
        </dl>
    </div>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Assigned staff</h5>
    </div>
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Staff name</th>
                <th>Counter</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payoutSchedule->staffAssignments as $assignment)
                <tr>
                    <td class="fw-semibold">{{ $assignment->user->name ?? '—' }}</td>
                    <td>{{ $assignment->counter->counter_number ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="table-empty">No staff assigned to this schedule.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
