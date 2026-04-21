@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Transaction Details</h2>
    <a href="{{ route('payout-transactions.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card p-4 mb-4">
    <div class="row">
        <div class="col-md-6">
            <p><strong>Senior:</strong> {{ $payoutTransaction->senior->name ?? '—' }}</p>
            <p><strong>OSCA ID:</strong> {{ $payoutTransaction->senior->osca_id ?? '—' }}</p>
            <p><strong>Cycle:</strong> {{ $payoutTransaction->cycle->cycle_name ?? '—' }}</p>
            <p><strong>Schedule:</strong>
                {{ $payoutTransaction->schedule->scheduled_date ?? '—' }}
            </p>
        </div>
        <div class="col-md-6">
            <p><strong>Counter:</strong>
                {{ $payoutTransaction->counter->counter_number ?? '—' }}
            </p>
            <p><strong>Amount:</strong>
                ₱{{ number_format($payoutTransaction->amount, 2) }}
            </p>
            <p><strong>Processed By:</strong>
                {{ $payoutTransaction->processor->name ?? '—' }}
            </p>
            <p><strong>Claimed At:</strong>
                {{ $payoutTransaction->claimed_at ?? '—' }}
            </p>
            <p><strong>Remarks:</strong>
                {{ $payoutTransaction->remarks ?? '—' }}
            </p>
        </div>
    </div>

    <div class="mt-3">
        <strong>Current Status:</strong>
        @if($payoutTransaction->claim_status === 'claimed')
            <span class="badge bg-success fs-6">Claimed</span>
        @elseif($payoutTransaction->claim_status === 'unclaimed')
            <span class="badge bg-warning text-dark fs-6">Unclaimed</span>
        @else
            <span class="badge bg-danger fs-6">Cancelled</span>
        @endif
    </div>
</div>

<h5>Update Claim Status</h5>
<div class="card p-4 mb-4">
    <form action="{{ route('payout-transactions.updateStatus', $payoutTransaction) }}" method="POST">
        @csrf @method('PATCH')
        <div class="d-flex align-items-center gap-3">
            <select name="claim_status" class="form-control w-auto">
                <option value="unclaimed" {{ $payoutTransaction->claim_status == 'unclaimed' ? 'selected' : '' }}>Unclaimed</option>
                <option value="claimed"   {{ $payoutTransaction->claim_status == 'claimed'   ? 'selected' : '' }}>Claimed</option>
                <option value="cancelled" {{ $payoutTransaction->claim_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </div>
    </form>
</div>

@if($payoutTransaction->submissions->count())
<h5>Document Submissions</h5>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr><th>Document</th><th>Submitted</th><th>Notes</th></tr>
    </thead>
    <tbody>
        @foreach($payoutTransaction->submissions as $submission)
        <tr>
            <td>{{ $submission->requirement->document_name ?? '—' }}</td>
            <td>
                @if($submission->is_submitted)
                    <span class="badge bg-success">Yes</span>
                @else
                    <span class="badge bg-danger">No</span>
                @endif
            </td>
            <td>{{ $submission->notes ?? '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection