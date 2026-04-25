@extends('layouts.app')
@section('topbar-title', 'Edit transaction')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('payout-transactions.index') }}" class="text-muted text-decoration-none">Transactions</a> / Edit</div>
        <h2 class="page-title">Edit transaction</h2>
    </div>
</div>

<form action="{{ route('payout-transactions.update', $payoutTransaction) }}" method="POST">
    @csrf @method('PUT')
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Recipient and cycle</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="senior_id">Senior citizen</label>
                    <select name="senior_id" id="senior_id" class="form-select" required>
                        @foreach($seniors as $senior)
                            <option value="{{ $senior->id }}" {{ $payoutTransaction->senior_id == $senior->id ? 'selected' : '' }}>
                                {{ $senior->name }} ({{ $senior->osca_id }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="cycle_id">Payout cycle</label>
                    <select name="cycle_id" id="cycle_id" class="form-select" required>
                        @foreach($cycles as $cycle)
                            <option value="{{ $cycle->id }}" {{ $payoutTransaction->cycle_id == $cycle->id ? 'selected' : '' }}>
                                {{ $cycle->cycle_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Schedule and counter</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="schedule_id">Schedule</label>
                    <select name="schedule_id" id="schedule_id" class="form-select">
                        <option value="">No schedule</option>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}" {{ $payoutTransaction->schedule_id == $schedule->id ? 'selected' : '' }}>
                                {{ $schedule->barangay->name ?? 'No barangay' }} — {{ $schedule->scheduled_date }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="counter_id">Counter</label>
                    <select name="counter_id" id="counter_id" class="form-select">
                        <option value="">No counter</option>
                        @foreach($counters as $counter)
                            <option value="{{ $counter->id }}" {{ $payoutTransaction->counter_id == $counter->id ? 'selected' : '' }}>
                                {{ $counter->counter_number }}@if($counter->label) — {{ $counter->label }}@endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Amount and status</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="amount">Amount (₱)</label>
                    <input type="number" name="amount" id="amount" step="0.01" class="form-control" value="{{ $payoutTransaction->amount }}" required>
                </div>
                <div>
                    <label class="form-label" for="claim_status">Claim status</label>
                    <select name="claim_status" id="claim_status" class="form-select" required>
                        <option value="unclaimed" {{ $payoutTransaction->claim_status == 'unclaimed' ? 'selected' : '' }}>Unclaimed</option>
                        <option value="claimed"   {{ $payoutTransaction->claim_status == 'claimed'   ? 'selected' : '' }}>Claimed</option>
                        <option value="cancelled" {{ $payoutTransaction->claim_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="span-2">
                    <label class="form-label" for="remarks">Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control" rows="2">{{ $payoutTransaction->remarks }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('payout-transactions.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>
@endsection
