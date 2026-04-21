@extends('layouts.app')
@section('content')
<h2>Record Payout Transaction</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('payout-transactions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Senior Citizen</label>
            <select name="senior_id" class="form-control" required>
                <option value="">-- Select Senior --</option>
                @foreach($seniors as $senior)
                    <option value="{{ $senior->id }}">
                        {{ $senior->name }} ({{ $senior->osca_id }})
                    </option>
                @endforeach
            </select>
            @error('senior_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Payout Cycle</label>
            <select name="cycle_id" class="form-control" required>
                <option value="">-- Select Cycle --</option>
                @foreach($cycles as $cycle)
                    <option value="{{ $cycle->id }}">{{ $cycle->cycle_name }}</option>
                @endforeach
            </select>
            @error('cycle_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Schedule</label>
            <select name="schedule_id" class="form-control">
                <option value="">-- Select Schedule --</option>
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}">
                        {{ $schedule->barangay->name ?? 'No Barangay' }}
                        — {{ $schedule->scheduled_date }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Counter</label>
            <select name="counter_id" class="form-control">
                <option value="">-- Select Counter --</option>
                @foreach($counters as $counter)
                    <option value="{{ $counter->id }}">
                        {{ $counter->counter_number }}
                        @if($counter->label) — {{ $counter->label }} @endif
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Amount (₱)</label>
            <input type="number" name="amount" class="form-control"
                step="0.01" min="0" placeholder="e.g. 500.00" required>
            @error('amount')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Claim Status</label>
            <select name="claim_status" class="form-control" required>
                <option value="unclaimed">Unclaimed</option>
                <option value="claimed">Claimed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Remarks <span class="text-muted">(optional)</span></label>
            <textarea name="remarks" class="form-control" rows="2"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Save Transaction</button>
        <a href="{{ route('payout-transactions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection