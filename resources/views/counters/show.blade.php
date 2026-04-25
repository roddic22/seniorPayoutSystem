@extends('layouts.app')
@section('topbar-title', 'Counter details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('counters.index') }}" class="text-muted text-decoration-none">Counters</a> / {{ $counter->counter_number }}</div>
        <h2 class="page-title">{{ $counter->counter_number }}</h2>
        <div class="page-sub">{{ $counter->label ?? 'No label' }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('counters.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <a href="{{ route('counters.edit', $counter) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Counter information</h5>
        @if($counter->is_active)
            <span class="pill pill-success">Active</span>
        @else
            <span class="pill pill-muted">Inactive</span>
        @endif
    </div>
    <div class="surface-body">
        <dl class="deflist">
            <dt>Counter number</dt><dd>{{ $counter->counter_number }}</dd>
            <dt>Label</dt><dd>{{ $counter->label ?? '—' }}</dd>
            <dt>Status</dt><dd>{{ $counter->is_active ? 'Active' : 'Inactive' }}</dd>
        </dl>
    </div>
</div>
@endsection
