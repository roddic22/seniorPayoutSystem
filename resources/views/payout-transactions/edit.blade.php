@extends('layouts.app')
@section('content')
<h2>Edit Transaction</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('payout-transactions.update', $payoutTransaction) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Senior Citizen</label>
            <select name="senior_id" class="form-control" required>
                @foreach($seniors as $senior)
                    <option value="{{ $senior->id }}"
                        {{ $payoutTransaction->senior_id == $senior->id ? 'selected' : '' }}>
                        {{ $senior->name }} ({{ $senior->osca_id }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Payout Cycle</label>
            <select name="cycle_id" class="form-control" required>
                @foreach($cycles as $cycle)
                    <option value="{{ $cycle->id }}"
                        {{ $payoutTransaction->cycle_id == $cycle->id ? 'selected' : '' }}>
                        {{ $cycle->cycle_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Schedule</label>
            <select name="schedule_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}"
                        {{ $payoutTransaction->schedule_id == $schedule->id ? 'selected' : '' }}>
                        {{ $schedule->barangay->name ?? 'No Barangay' }}
                        — {{ $schedule->scheduled_date }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Counter</label>
            <select name="counter_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($counters as $counter)
                    <option value="{{ $counter->id }}"
                        {{ $payoutTransaction->counter_id == $counter->id ? 'selected' : '' }}>
                        {{ $counter->counter_number }}
                        @if($counter->label) — {{ $counter->label }} @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Amount (₱)</label>
            <input type="number" name="amount" class="form-control"
                step="0.01" value="{{ $payoutTransaction->amount }}" required>
        </div>
        <div class="mb-3">
            <label>Claim Status</label>
            <select name="claim_status" class="form-control" required>
                <option value="unclaimed" {{ $payoutTransaction->claim_status == 'unclaimed' ? 'selected' : '' }}>Unclaimed</option>
                <option value="claimed"   {{ $payoutTransaction->claim_status == 'claimed'   ? 'selected' : '' }}>Claimed</option>
                <option value="cancelled" {{ $payoutTransaction->claim_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control" rows="2">{{ $payoutTransaction->remarks }}</textarea>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('payout-transactions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection