@extends('layouts.app')
@section('topbar-title', 'Dashboard')
@section('topbar-sub', 'Overview of payout activity')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Overview</div>
        <h2 class="page-title">Payout dashboard</h2>
        <div class="page-sub">Real-time view of seniors, claims and disbursement activity.</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('payout-transactions.create') }}" class="btn btn-outline-secondary">
            <i class="bi bi-plus-lg me-1"></i> Record claim
        </a>
        <a href="{{ route('reports.index') }}" class="btn btn-primary">
            <i class="bi bi-bar-chart me-1"></i> Generate report
        </a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-sm-6 col-xl-3">
        <div class="kpi kpi-info">
            <div class="kpi-icon"><i class="bi bi-people"></i></div>
            <div class="kpi-label">Registered Seniors</div>
            <div class="kpi-value">{{ number_format($totalSeniors) }}</div>
            <div class="kpi-foot">Across {{ $totalBarangays }} barangays</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi kpi-success">
            <div class="kpi-icon"><i class="bi bi-check2-circle"></i></div>
            <div class="kpi-label">Claimed</div>
            <div class="kpi-value">{{ number_format($totalClaimed) }}</div>
            <div class="kpi-foot">Successfully released</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi kpi-warning">
            <div class="kpi-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="kpi-label">Unclaimed</div>
            <div class="kpi-value">{{ number_format($totalUnclaimed) }}</div>
            <div class="kpi-foot">Pending pickup</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi kpi-danger">
            <div class="kpi-icon"><i class="bi bi-x-circle"></i></div>
            <div class="kpi-label">Cancelled</div>
            <div class="kpi-value">{{ number_format($totalCancelled) }}</div>
            <div class="kpi-foot">Voided transactions</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="kpi">
            <div class="kpi-icon"><i class="bi bi-cash-stack"></i></div>
            <div class="kpi-label">Total released</div>
            <div class="kpi-value">₱{{ number_format($totalAmount, 2) }}</div>
            <div class="kpi-foot">Sum of claimed transactions</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="kpi">
            <div class="kpi-icon"><i class="bi bi-arrow-repeat"></i></div>
            <div class="kpi-label">Payout cycles</div>
            <div class="kpi-value">{{ number_format($totalCycles) }}</div>
            <div class="kpi-foot">All-time configured</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="kpi">
            <div class="kpi-icon"><i class="bi bi-geo-alt"></i></div>
            <div class="kpi-label">Barangays served</div>
            <div class="kpi-value">{{ number_format($totalBarangays) }}</div>
            <div class="kpi-foot">In coverage area</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-6">
        <div class="surface">
            <div class="surface-head">
                <h5>Active payout cycles</h5>
                <a href="{{ route('payout-cycles.index') }}" class="btn btn-sm btn-ghost">View all <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="surface-body">
                @forelse($activeCycles as $cycle)
                    <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--c-line-soft) !important;">
                        <div>
                            <div class="fw-semibold" style="font-size: .88rem;">{{ $cycle->cycle_name }}</div>
                            <div class="text-muted" style="font-size: .75rem;">{{ $cycle->period_start }} — {{ $cycle->period_end }}</div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="pill pill-success">Active</span>
                            <a href="{{ route('payout-cycles.show', $cycle) }}" class="btn btn-sm btn-outline-secondary">Open</a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state py-3">
                        <i class="bi bi-inbox d-block"></i>
                        <div>No active cycles right now.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="surface">
            <div class="surface-head">
                <h5>Upcoming schedules</h5>
                <a href="{{ route('payout-schedules.index') }}" class="btn btn-sm btn-ghost">View all <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="surface-body">
                @forelse($upcomingSchedules as $schedule)
                    <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--c-line-soft) !important;">
                        <div>
                            <div class="fw-semibold" style="font-size: .88rem;">
                                {{ $schedule->barangay->name ?? 'Unassigned barangay' }}
                            </div>
                            <div class="text-muted" style="font-size: .75rem;">
                                <i class="bi bi-calendar3 me-1"></i>{{ $schedule->scheduled_date }}
                            </div>
                        </div>
                        <span class="pill pill-info">{{ $schedule->cycle->cycle_name ?? '—' }}</span>
                    </div>
                @empty
                    <div class="empty-state py-3">
                        <i class="bi bi-calendar-x d-block"></i>
                        <div>No upcoming schedules.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Recent transactions</h5>
        <a href="{{ route('payout-transactions.index') }}" class="btn btn-sm btn-ghost">View all <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Senior</th>
                <th>Cycle</th>
                <th class="text-end">Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentTransactions as $transaction)
                <tr>
                    <td class="fw-semibold">{{ $transaction->senior->name ?? '—' }}</td>
                    <td class="text-muted">{{ $transaction->cycle->cycle_name ?? '—' }}</td>
                    <td class="text-end fw-semibold">₱{{ number_format($transaction->amount, 2) }}</td>
                    <td>
                        @if($transaction->claim_status === 'claimed')
                            <span class="pill pill-success">Claimed</span>
                        @elseif($transaction->claim_status === 'unclaimed')
                            <span class="pill pill-warning">Unclaimed</span>
                        @else
                            <span class="pill pill-danger">Cancelled</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="table-empty">No transactions recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
