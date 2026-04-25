@extends('layouts.app')
@section('topbar-title', 'New schedule')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('payout-schedules.index') }}" class="text-muted text-decoration-none">Schedules</a> / New</div>
        <h2 class="page-title">Create payout schedule</h2>
        <div class="page-sub">Plan a barangay payout date.</div>
    </div>
</div>

<form action="{{ route('payout-schedules.store') }}" method="POST">
    @csrf
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Cycle and location</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="cycle_id">Payout cycle</label>
                    <select name="cycle_id" id="cycle_id" class="form-select" required>
                        <option value="">Select an active cycle</option>
                        @foreach($cycles as $cycle)
                            <option value="{{ $cycle->id }}">{{ $cycle->cycle_name }}</option>
                        @endforeach
                    </select>
                    @error('cycle_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="barangay_id">Barangay</label>
                    <select name="barangay_id" id="barangay_id" class="form-select">
                        <option value="">Select barangay</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Date and venue</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="scheduled_date">Scheduled date</label>
                    <input type="date" name="scheduled_date" id="scheduled_date" class="form-control" required>
                    @error('scheduled_date')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="venue">Venue</label>
                    <input type="text" name="venue" id="venue" class="form-control" placeholder="e.g. Barangay Hall">
                </div>
                <div>
                    <label class="form-label" for="time_start">Time start</label>
                    <input type="time" name="time_start" id="time_start" class="form-control">
                </div>
                <div>
                    <label class="form-label" for="time_end">Time end</label>
                    <input type="time" name="time_end" id="time_end" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('payout-schedules.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save schedule</button>
        </div>
    </div>
</form>
@endsection
