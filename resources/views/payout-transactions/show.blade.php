@extends('layouts.app')
@section('topbar-title', 'Transaction details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('payout-transactions.index') }}" class="text-muted text-decoration-none">Transactions</a> / Details</div>
        <h2 class="page-title">{{ $payoutTransaction->senior->name ?? 'Transaction' }}</h2>
        <div class="page-sub">{{ $payoutTransaction->cycle->cycle_name ?? '—' }} · ₱{{ number_format($payoutTransaction->amount, 2) }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('payout-transactions.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        @if(auth()->user()?->role !== 'staff')
            <a href="{{ route('payout-transactions.edit', $payoutTransaction) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
        @endif
    </div>
</div>

<div class="surface mb-3">
    <div class="surface-head">
        <h5>Transaction information</h5>
        @if($payoutTransaction->claim_status === 'claimed')
            <span class="pill pill-success">Claimed</span>
        @elseif($payoutTransaction->claim_status === 'unclaimed')
            <span class="pill pill-warning">Unclaimed</span>
        @else
            <span class="pill pill-danger">Cancelled</span>
        @endif
    </div>
    <div class="surface-body">
        <div class="row g-4">
            <div class="col-md-6">
                <dl class="deflist">
                    <dt>Senior</dt><dd>{{ $payoutTransaction->senior->name ?? '—' }}</dd>
                    <dt>OSCA ID</dt><dd>{{ $payoutTransaction->senior->osca_id ?? '—' }}</dd>
                    <dt>Cycle</dt><dd>{{ $payoutTransaction->cycle->cycle_name ?? '—' }}</dd>
                    <dt>Schedule</dt><dd>{{ $payoutTransaction->schedule->scheduled_date ?? '—' }}</dd>
                </dl>
            </div>
            <div class="col-md-6">
                <dl class="deflist">
                    <dt>Counter</dt><dd>{{ $payoutTransaction->counter->counter_number ?? '—' }}</dd>
                    <dt>Amount</dt><dd>₱{{ number_format($payoutTransaction->amount, 2) }}</dd>
                    <dt>Processed by</dt><dd>{{ $payoutTransaction->processor->name ?? '—' }}</dd>
                    <dt>Claimed at</dt><dd>{{ $payoutTransaction->claimed_at ?? '—' }}</dd>
                    <dt>Remarks</dt><dd>{{ $payoutTransaction->remarks ?? '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()?->role !== 'staff')
    <div class="surface mb-3">
        <div class="surface-head">
            <h5>Update claim status</h5>
        </div>
        <div class="surface-body">
            <form action="{{ route('payout-transactions.updateStatus', $payoutTransaction) }}" method="POST" class="d-flex flex-wrap align-items-end gap-2">
                @csrf @method('PATCH')
                <div style="min-width: 220px;">
                    <label class="form-label" for="claim_status">Claim status</label>
                    <select name="claim_status" id="claim_status" class="form-select">
                        <option value="unclaimed" {{ $payoutTransaction->claim_status == 'unclaimed' ? 'selected' : '' }}>Unclaimed</option>
                        <option value="claimed"   {{ $payoutTransaction->claim_status == 'claimed'   ? 'selected' : '' }}>Claimed</option>
                        <option value="cancelled" {{ $payoutTransaction->claim_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update status</button>
            </form>
        </div>
    </div>
@endif

@if($payoutTransaction->submissions->count())
<div class="surface">
    <div class="surface-head">
        <h5>Document submissions</h5>
    </div>
    <table class="table mb-0">
        <thead>
            <tr>
                <th>Document</th>
                <th>Submitted</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payoutTransaction->submissions as $submission)
                <tr>
                    <td class="fw-semibold">{{ $submission->requirement->document_name ?? '—' }}</td>
                    <td>
                        @if($submission->is_submitted)
                            <span class="pill pill-success">Submitted</span>
                        @else
                            <span class="pill pill-danger">Missing</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $submission->notes ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
