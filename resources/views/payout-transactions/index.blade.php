@extends('layouts.app')
@section('topbar-title', 'Transactions')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Payouts</div>
        <h2 class="page-title">Payout transactions</h2>
        <div class="page-sub">Disbursement records and claim status.</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('payout-transactions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Record transaction
        </a>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Senior</th>
                <th>Barangay</th>
                <th>Cycle</th>
                <th>Counter</th>
                <th class="text-end">Amount</th>
                <th>Status</th>
                <th>Claimed at</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td class="fw-semibold">{{ $transaction->senior->name ?? '—' }}</td>
                    <td>{{ $transaction->senior->barangay->name ?? '—' }}</td>
                    <td class="text-muted">{{ $transaction->cycle->cycle_name ?? '—' }}</td>
                    <td>{{ $transaction->counter->counter_number ?? '—' }}</td>
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
                    <td class="text-muted">{{ $transaction->claimed_at ?? '—' }}</td>
                    <td class="text-end">
                        <div class="row-actions">
                            <a href="{{ route('payout-transactions.show', $transaction) }}" class="row-action view" title="View"><i class="bi bi-eye"></i></a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('payout-transactions.edit', $transaction) }}" class="row-action edit" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('payout-transactions.destroy', $transaction) }}" method="POST"
                                onsubmit="return confirm('Delete this transaction?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="row-action delete" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="table-empty">No transactions recorded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $transactions->links() }}
</div>
@endsection