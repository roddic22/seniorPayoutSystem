@extends('layouts.app')
@section('topbar-title', 'Edit assignment')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('staff-assignments.index') }}" class="text-muted text-decoration-none">Staff assignments</a> / Edit</div>
        <h2 class="page-title">Edit staff assignment</h2>
    </div>
</div>

<form action="{{ route('staff-assignments.update', $staffAssignment) }}" method="POST">
    @csrf @method('PUT')
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Schedule</div>
            <div class="form-grid">
                <div class="span-2">
                    <label class="form-label" for="schedule_id">Payout schedule</label>
                    <select name="schedule_id" id="schedule_id" class="form-select" required>
                        <option value="">Select schedule</option>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}" {{ $staffAssignment->schedule_id == $schedule->id ? 'selected' : '' }}>
                                {{ $schedule->cycle->cycle_name ?? '—' }} —
                                {{ $schedule->barangay->name ?? 'No barangay' }} —
                                {{ $schedule->scheduled_date }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Staff and counter</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="user_id">Staff member</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $staffAssignment->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label" for="counter_id">Counter</label>
                    <select name="counter_id" id="counter_id" class="form-select" required>
                        @foreach($counters as $counter)
                            <option value="{{ $counter->id }}" {{ $staffAssignment->counter_id == $counter->id ? 'selected' : '' }}>
                                {{ $counter->counter_number }}@if($counter->label) — {{ $counter->label }}@endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('staff-assignments.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>
@endsection
