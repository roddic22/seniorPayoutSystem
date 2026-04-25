@extends('layouts.app')
@section('topbar-title', 'Cycle details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('payout-cycles.index') }}" class="text-muted text-decoration-none">Cycles</a> / {{ $payoutCycle->cycle_name }}</div>
        <h2 class="page-title">{{ $payoutCycle->cycle_name }}</h2>
        <div class="page-sub">{{ $payoutCycle->period_start }} — {{ $payoutCycle->period_end }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('payout-cycles.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <a href="{{ route('payout-cycles.edit', $payoutCycle) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="surface h-100">
            <div class="surface-head">
                <h5>Cycle information</h5>
                @if($payoutCycle->status === 'active')
                    <span class="pill pill-success">Active</span>
                @elseif($payoutCycle->status === 'draft')
                    <span class="pill pill-muted">Draft</span>
                @else
                    <span class="pill pill-dark">Completed</span>
                @endif
            </div>
            <div class="surface-body">
                <dl class="deflist">
                    <dt>Period start</dt><dd>{{ $payoutCycle->period_start }}</dd>
                    <dt>Period end</dt><dd>{{ $payoutCycle->period_end }}</dd>
                    <dt>Status</dt><dd>{{ ucfirst($payoutCycle->status) }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="kpi kpi-success">
            <div class="kpi-icon"><i class="bi bi-check2-circle"></i></div>
            <div class="kpi-label">Claimed</div>
            <div class="kpi-value">{{ number_format($totalClaimed) }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="kpi kpi-warning">
            <div class="kpi-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="kpi-label">Unclaimed</div>
            <div class="kpi-value">{{ number_format($totalUnclaimed) }}</div>
        </div>
    </div>
</div>

<div class="surface mb-3">
    <div class="surface-head">
        <h5>Schedules</h5>
        <a href="{{ route('payout-schedules.index') }}" class="btn btn-sm btn-ghost">All schedules <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Barangay</th>
                <th>Date</th>
                <th>Time</th>
                <th>Venue</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td class="fw-semibold">{{ $schedule->barangay->name ?? '—' }}</td>
                    <td>{{ $schedule->scheduled_date }}</td>
                    <td>{{ $schedule->time_start }}@if($schedule->time_end) — {{ $schedule->time_end }}@endif</td>
                    <td>{{ $schedule->venue ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="table-empty">No schedules added to this cycle.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Document requirements</h5>
    </div>
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Document</th>
                <th>Description</th>
                <th>Mandatory</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requirements as $req)
                <tr>
                    <td class="fw-semibold">{{ $req->document_name }}</td>
                    <td class="text-muted">{{ $req->description ?? '—' }}</td>
                    <td>
                        @if($req->is_mandatory)
                            <span class="pill pill-danger">Required</span>
                        @else
                            <span class="pill pill-muted">Optional</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="table-empty">No requirements set.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
