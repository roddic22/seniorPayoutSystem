@extends('layouts.app')
@section('topbar-title', 'Assignment details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('staff-assignments.index') }}" class="text-muted text-decoration-none">Staff assignments</a> / Details</div>
        <h2 class="page-title">{{ $staffAssignment->user->name ?? 'Assignment' }}</h2>
        <div class="page-sub">Counter {{ $staffAssignment->counter->counter_number ?? '—' }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('staff-assignments.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <a href="{{ route('staff-assignments.edit', $staffAssignment) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Assignment information</h5>
    </div>
    <div class="surface-body">
        <dl class="deflist">
            <dt>Staff member</dt><dd>{{ $staffAssignment->user->name ?? '—' }}</dd>
            <dt>Cycle</dt><dd>{{ $staffAssignment->schedule->cycle->cycle_name ?? '—' }}</dd>
            <dt>Barangay</dt><dd>{{ $staffAssignment->schedule->barangay->name ?? '—' }}</dd>
            <dt>Schedule date</dt><dd>{{ $staffAssignment->schedule->scheduled_date ?? '—' }}</dd>
            <dt>Time</dt><dd>{{ $staffAssignment->schedule->time_start ?? '—' }}@if($staffAssignment->schedule->time_end) — {{ $staffAssignment->schedule->time_end }}@endif</dd>
            <dt>Venue</dt><dd>{{ $staffAssignment->schedule->venue ?? '—' }}</dd>
            <dt>Counter</dt><dd>{{ $staffAssignment->counter->counter_number ?? '—' }}</dd>
        </dl>
    </div>
</div>
@endsection
