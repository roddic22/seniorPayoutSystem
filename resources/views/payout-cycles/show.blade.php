@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>{{ $payoutCycle->cycle_name }}</h2>
    <a href="{{ route('payout-cycles.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card p-3">
            <p><strong>Period:</strong> {{ $payoutCycle->period_start }} to {{ $payoutCycle->period_end }}</p>
            <p><strong>Status:</strong>
                @if($payoutCycle->status === 'active')
                    <span class="badge bg-success">Active</span>
                @elseif($payoutCycle->status === 'draft')
                    <span class="badge bg-secondary">Draft</span>
                @else
                    <span class="badge bg-dark">Completed</span>
                @endif
            </p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h4 class="text-success">{{ $totalClaimed }}</h4>
            <p class="mb-0">Total Claimed</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h4 class="text-danger">{{ $totalUnclaimed }}</h4>
            <p class="mb-0">Total Unclaimed</p>
        </div>
    </div>
</div>

<h5>Schedules</h5>
<table class="table table-bordered mb-4">
    <thead class="table-dark">
        <tr><th>Barangay</th><th>Date</th><th>Time</th><th>Venue</th></tr>
    </thead>
    <tbody>
        @forelse($schedules as $schedule)
        <tr>
            <td>{{ $schedule->barangay->name ?? '—' }}</td>
            <td>{{ $schedule->scheduled_date }}</td>
            <td>{{ $schedule->time_start }} - {{ $schedule->time_end }}</td>
            <td>{{ $schedule->venue ?? '—' }}</td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center">No schedules yet.</td></tr>
        @endforelse
    </tbody>
</table>

<h5>Document Requirements</h5>
<table class="table table-bordered mb-4">
    <thead class="table-dark">
        <tr><th>Document</th><th>Description</th><th>Mandatory</th></tr>
    </thead>
    <tbody>
        @forelse($requirements as $req)
        <tr>
            <td>{{ $req->document_name }}</td>
            <td>{{ $req->description ?? '—' }}</td>
            <td>{{ $req->is_mandatory ? 'Yes' : 'No' }}</td>
        </tr>
        @empty
        <tr><td colspan="3" class="text-center">No requirements set.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection