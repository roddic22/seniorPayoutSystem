@extends('layouts.app')
@section('content')

<div class="mb-4">
    <h2 class="fw-bold">Dashboard</h2>
    <p class="text-muted">Senior Citizen Payout Management System — Overview</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3 text-center border-primary">
            <h2 class="text-primary fw-bold">{{ $totalSeniors }}</h2>
            <p class="mb-0">Registered Seniors</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center border-success">
            <h2 class="text-success fw-bold">{{ $totalClaimed }}</h2>
            <p class="mb-0">Claimed</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center border-warning">
            <h2 class="text-warning fw-bold">{{ $totalUnclaimed }}</h2>
            <p class="mb-0">Unclaimed</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center border-danger">
            <h2 class="text-danger fw-bold">{{ $totalCancelled }}</h2>
            <p class="mb-0">Cancelled</p>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h4 class="fw-bold">₱{{ number_format($totalAmount, 2) }}</h4>
            <p class="mb-0 text-muted">Total Amount Released</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h4 class="fw-bold">{{ $totalCycles }}</h4>
            <p class="mb-0 text-muted">Payout Cycles</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 text-center">
            <h4 class="fw-bold">{{ $totalBarangays }}</h4>
            <p class="mb-0 text-muted">Barangays</p>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card p-3">
            <h5 class="mb-3">Active Payout Cycles</h5>
            @forelse($activeCycles as $cycle)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>{{ $cycle->cycle_name }}</span>
                <div>
                    <span class="badge bg-success">Active</span>
                    <a href="{{ route('payout-cycles.show', $cycle) }}"
                        class="btn btn-sm btn-outline-primary ms-2">View</a>
                </div>
            </div>
            @empty
            <p class="text-muted">No active cycles.</p>
            @endforelse
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3">
            <h5 class="mb-3">Upcoming Schedules</h5>
            @forelse($upcomingSchedules as $schedule)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span>
                    {{ $schedule->barangay->name ?? 'No Barangay' }}
                    <small class="text-muted">— {{ $schedule->scheduled_date }}</small>
                </span>
                <span class="badge bg-info text-dark">
                    {{ $schedule->cycle->cycle_name ?? '—' }}
                </span>
            </div>
            @empty
            <p class="text-muted">No upcoming schedules.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="card p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Recent Transactions</h5>
        <a href="{{ route('payout-transactions.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <table class="table table-bordered table-striped mb-0">
        <thead class="table-dark">
            <tr>
                <th>Senior</th>
                <th>Cycle</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentTransactions as $transaction)
            <tr>
                <td>{{ $transaction->senior->name ?? '—' }}</td>
                <td>{{ $transaction->cycle->cycle_name ?? '—' }}</td>
                <td>₱{{ number_format($transaction->amount, 2) }}</td>
                <td>
                    @if($transaction->claim_status === 'claimed')
                        <span class="badge bg-success">Claimed</span>
                    @elseif($transaction->claim_status === 'unclaimed')
                        <span class="badge bg-warning text-dark">Unclaimed</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">No transactions yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection