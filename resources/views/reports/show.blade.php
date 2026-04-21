@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Summary Report — {{ $cycle->cycle_name }}</h2>
    <div>
        <button onclick="window.print()" class="btn btn-secondary">Print</button>
        <a href="{{ route('reports.index') }}" class="btn btn-dark">Back</a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center p-3">
            <h3>{{ $totalSeniors }}</h3>
            <p class="mb-0">Total Records</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3 border-success">
            <h3 class="text-success">{{ $totalClaimed }}</h3>
            <p class="mb-0">Claimed</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3 border-warning">
            <h3 class="text-warning">{{ $totalUnclaimed }}</h3>
            <p class="mb-0">Unclaimed</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center p-3 border-danger">
            <h3 class="text-danger">{{ $totalCancelled }}</h3>
            <p class="mb-0">Cancelled</p>
        </div>
    </div>
</div>

<div class="card p-3 mb-4">
    <h5>Total Amount Released: <span class="text-success">₱{{ number_format($totalAmount, 2) }}</span></h5>
    <p><strong>Period:</strong> {{ $cycle->period_start }} to {{ $cycle->period_end }}</p>
    <p><strong>Status:</strong> {{ ucfirst($cycle->status) }}</p>
</div>

<h5>Transaction Breakdown</h5>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Senior Name</th>
            <th>OSCA ID</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Claimed At</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $transaction)
        <tr>
            <td>{{ $transaction->senior->name ?? '—' }}</td>
            <td>{{ $transaction->senior->osca_id ?? '—' }}</td>
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
            <td>{{ $transaction->claimed_at ?? '—' }}</td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">No transactions for this cycle.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection