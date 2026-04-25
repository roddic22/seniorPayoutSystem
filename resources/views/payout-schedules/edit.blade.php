@extends('layouts.app')
@section('topbar-title', 'Edit schedule')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('payout-schedules.index') }}" class="text-muted text-decoration-none">Schedules</a> / Edit</div>
        <h2 class="page-title">Edit payout schedule</h2>
    </div>
</div>

<form action="{{ route('payout-schedules.update', $payoutSchedule) }}" method="POST">
    @csrf @method('PUT')
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Cycle and location</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="cycle_id">Payout cycle</label>
                    <select name="cycle_id" id="cycle_id" class="form-select" required>
                        <option value="">Select cycle</option>
                        @foreach($cycles as $cycle)
                            <option value="{{ $cycle->id }}" {{ $payoutSchedule->cycle_id == $cycle->id ? 'selected' : '' }}>
                                {{ $cycle->cycle_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="barangay_id">Barangay</label>
                    <select name="barangay_id" id="barangay_id" class="form-select">
                        <option value="">Select barangay</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->id }}" {{ $payoutSchedule->barangay_id == $barangay->id ? 'selected' : '' }}>
                                {{ $barangay->name }}
                            </option>
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
                    <input type="date" name="scheduled_date" id="scheduled_date" class="form-control" value="{{ $payoutSchedule->scheduled_date }}" required>
                </div>
                <div>
                    <label class="form-label" for="venue">Venue</label>
                    <input type="text" name="venue" id="venue" class="form-control" value="{{ $payoutSchedule->venue }}">
                </div>
                <div>
                    <label class="form-label" for="time_start">Time start</label>
                    <input type="time" name="time_start" id="time_start" class="form-control" value="{{ $payoutSchedule->time_start }}">
                </div>
                <div>
                    <label class="form-label" for="time_end">Time end</label>
                    <input type="time" name="time_end" id="time_end" class="form-control" value="{{ $payoutSchedule->time_end }}">
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('payout-schedules.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>
@endsection
