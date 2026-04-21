@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Payout Transactions</h2>
    <a href="{{ route('payout-transactions.create') }}" class="btn btn-primary">+ Record Transaction</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Senior</th>
            <th>Cycle</th>
            <th>Counter</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Claimed At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $transaction)
        <tr>
            <td>{{ $transaction->senior->name ?? '—' }}</td>
            <td>{{ $transaction->cycle->cycle_name ?? '—' }}</td>
            <td>{{ $transaction->counter->counter_number ?? '—' }}</td>
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
            <td>
                <a href="{{ route('payout-transactions.show', $transaction) }}"
                    class="btn btn-sm btn-info">View</a>
                <a href="{{ route('payout-transactions.edit', $transaction) }}"
                    class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('payout-transactions.destroy', $transaction) }}"
                    method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this transaction?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center">No transactions yet.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $transactions->links() }}
@endsection