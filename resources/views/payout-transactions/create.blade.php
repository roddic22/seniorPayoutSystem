@extends('layouts.app')
@section('topbar-title', 'Record transaction')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('payout-transactions.index') }}" class="text-muted text-decoration-none">Transactions</a> / New</div>
        <h2 class="page-title">Record payout transaction</h2>
        <div class="page-sub">Log a disbursement to a senior citizen.</div>
    </div>
</div>

<form action="{{ route('payout-transactions.store') }}" method="POST">
    @csrf
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Recipient and cycle</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="senior_id">Senior citizen</label>
                    <select name="senior_id" id="senior_id" class="form-select" required>
                        <option value="">Select senior</option>
                        @foreach($seniors as $senior)
                            <option value="{{ $senior->id }}">{{ $senior->name }} ({{ $senior->osca_id }})</option>
                        @endforeach
                    </select>
                    @error('senior_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="cycle_id">Payout cycle</label>
                    <select name="cycle_id" id="cycle_id" class="form-select" required>
                        <option value="">Select cycle</option>
                        @foreach($cycles as $cycle)
                            <option value="{{ $cycle->id }}">{{ $cycle->cycle_name }}</option>
                        @endforeach
                    </select>
                    @error('cycle_id')<div class="form-error">{{ $message }}</div>@enderror
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
                            <option value="{{ $schedule->id }}">
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
                            <option value="{{ $counter->id }}">
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
                    <input type="number" name="amount" id="amount" step="0.01" min="0" class="form-control" placeholder="500.00" required>
                    @error('amount')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="claim_status">Claim status</label>
                    <select name="claim_status" id="claim_status" class="form-select" required>
                        <option value="unclaimed">Unclaimed</option>
                        <option value="claimed">Claimed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="span-2">
                    <label class="form-label" for="remarks">Remarks <span class="text-muted">(optional)</span></label>
                    <textarea name="remarks" id="remarks" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('payout-transactions.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save transaction</button>
        </div>
    </div>
</form>
@endsection
