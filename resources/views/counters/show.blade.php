@extends('layouts.app')
@section('content')
<h2>Counter Details</h2>
<div class="card p-4 mt-3">
    <p><strong>Counter Number:</strong> {{ $counter->counter_number }}</p>
    <p><strong>Label:</strong> {{ $counter->label ?? '—' }}</p>
    <p><strong>Status:</strong>
        @if($counter->is_active)
            <span class="badge bg-success">Active</span>
        @else
            <span class="badge bg-secondary">Inactive</span>
        @endif
    </p>
</div>
<a href="{{ route('counters.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection