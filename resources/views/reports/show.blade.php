@extends('layouts.app')
@section('topbar-title', 'Summary report')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('reports.index') }}" class="text-muted text-decoration-none">Reports</a> / Summary</div>
        <h2 class="page-title">Summary — {{ $cycle->cycle_name }}</h2>
        <div class="page-sub">{{ $cycle->period_start }} to {{ $cycle->period_end }} · {{ ucfirst($cycle->status) }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer me-1"></i> Print
        </button>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-sm-6 col-xl-3">
        <div class="kpi kpi-info">
            <div class="kpi-icon"><i class="bi bi-people"></i></div>
            <div class="kpi-label">Total records</div>
            <div class="kpi-value">{{ number_format($totalSeniors) }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi kpi-success">
            <div class="kpi-icon"><i class="bi bi-check2-circle"></i></div>
            <div class="kpi-label">Claimed</div>
            <div class="kpi-value">{{ number_format($totalClaimed) }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi kpi-warning">
            <div class="kpi-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="kpi-label">Unclaimed</div>
            <div class="kpi-value">{{ number_format($totalUnclaimed) }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi kpi-danger">
            <div class="kpi-icon"><i class="bi bi-x-circle"></i></div>
            <div class="kpi-label">Cancelled</div>
            <div class="kpi-value">{{ number_format($totalCancelled) }}</div>
        </div>
    </div>
</div>

<div class="surface mb-3">
    <div class="surface-body">
        <dl class="deflist">
            <dt>Total amount released</dt>
            <dd class="fw-semibold" style="color: var(--c-success);">₱{{ number_format($totalAmount, 2) }}</dd>
            <dt>Period</dt>
            <dd>{{ $cycle->period_start }} to {{ $cycle->period_end }}</dd>
            <dt>Status</dt>
            <dd>{{ ucfirst($cycle->status) }}</dd>
        </dl>
    </div>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Transaction breakdown</h5>
    </div>
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Senior name</th>
                <th>OSCA ID</th>
                <th class="text-end">Amount</th>
                <th>Status</th>
                <th>Claimed at</th>
            </tr>
        </thead>
        <tbody>
           @forelse($transactions as $transaction)
<tr>
    <td>{{ $transaction->senior_name ?? '—' }}</td>
    <td>{{ $transaction->osca_id ?? '—' }}</td>
    <td class="text-end fw-semibold">₱{{ number_format($transaction->amount, 2) }}</td>
    <td>
        @if($transaction->claim_status === 'claimed')
            <span class="badge bg-success">Claimed</span>
        @elseif($transaction->claim_status === 'unclaimed')
            <span class="badge bg-warning text-dark">Unclaimed</span>
        @else
            <span class="badge bg-danger">Cancelled</span>
        @endif
    </td>
    <td>{{ $transaction->claimed_at ?? '—' }}</td>
</tr>
@empty
<tr><td colspan="5" class="text-center">No transactions for this cycle.</td></tr>
@endforelse
        </tbody>
    </table>
</div>
@endsection
