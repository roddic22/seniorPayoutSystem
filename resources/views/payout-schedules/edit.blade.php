@extends('layouts.app')
@section('topbar-title', 'Edit Schedule')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Schedules / Edit</div>
        <h2 class="page-title">Edit payout schedule</h2>
    </div>
    <div class="page-actions">
        <a href="{{ route('payout-schedules.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger mb-3">
    <i class="bi bi-exclamation-triangle me-1"></i>
    Please fix the following:
    <ul class="mb-0 mt-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="surface">
    <form action="{{ route('payout-schedules.update', $payoutSchedule) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-section">
            <div class="form-section-title">Cycle and location</div>
            <div class="form-grid">
                <div>
                    <label class="form-label">Payout Cycle</label>
                    <select name="cycle_id" class="form-select" required>
                        <option value="">-- Select Cycle --</option>
                        @foreach($cycles as $cycle)
                            <option value="{{ $cycle->id }}"
                                {{ $payoutSchedule->cycle_id == $cycle->id ? 'selected' : '' }}>
                                {{ $cycle->cycle_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cycle_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label">Barangay</label>
                    <select name="barangay_id" class="form-select">
                        <option value="">-- Select Barangay --</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->id }}"
                                {{ $payoutSchedule->barangay_id == $barangay->id ? 'selected' : '' }}>
                                {{ $barangay->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('barangay_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Date and venue</div>
            <div class="form-grid">
                <div>
                    <label class="form-label">Scheduled Date</label>
                    <input type="date" name="scheduled_date" class="form-control"
                        value="{{ $payoutSchedule->scheduled_date }}" required>
                    @error('scheduled_date')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label">Venue</label>
                    <input type="text" name="venue" class="form-control"
                        value="{{ $payoutSchedule->venue }}"
                        placeholder="e.g. Barangay Hall">
                </div>
                <div>
                    <label class="form-label">Time Start</label>
                    <input type="time" name="time_start" class="form-control"
                        value="{{ $payoutSchedule->time_start }}">
                </div>
                <div>
                    <label class="form-label">Time End</label>
                    <input type="time" name="time_end" class="form-control"
                        value="{{ $payoutSchedule->time_end }}">
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('payout-schedules.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i> Save changes
            </button>
        </div>
    </form>
</div>
@endsection