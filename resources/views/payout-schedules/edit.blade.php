@extends('layouts.app')
@section('content')
<h2>Edit Payout Schedule</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('payout-schedules.update', $payoutSchedule) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Payout Cycle</label>
            <select name="cycle_id" class="form-control" required>
                <option value="">-- Select Cycle --</option>
                @foreach($cycles as $cycle)
                    <option value="{{ $cycle->id }}"
                        {{ $payoutSchedule->cycle_id == $cycle->id ? 'selected' : '' }}>
                        {{ $cycle->cycle_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Barangay</label>
            <select name="barangay_id" class="form-control">
                <option value="">-- Select Barangay --</option>
                @foreach($barangays as $barangay)
                    <option value="{{ $barangay->id }}"
                        {{ $payoutSchedule->barangay_id == $barangay->id ? 'selected' : '' }}>
                        {{ $barangay->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Scheduled Date</label>
            <input type="date" name="scheduled_date" class="form-control"
                value="{{ $payoutSchedule->scheduled_date }}" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Time Start</label>
                <input type="time" name="time_start" class="form-control"
                    value="{{ $payoutSchedule->time_start }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Time End</label>
                <input type="time" name="time_end" class="form-control"
                    value="{{ $payoutSchedule->time_end }}">
            </div>
        </div>
        <div class="mb-3">
            <label>Venue</label>
            <input type="text" name="venue" class="form-control"
                value="{{ $payoutSchedule->venue }}">
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('payout-schedules.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection