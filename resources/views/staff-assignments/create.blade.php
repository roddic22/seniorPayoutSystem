@extends('layouts.app')
@section('topbar-title', 'New assignment')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('staff-assignments.index') }}" class="text-muted text-decoration-none">Staff assignments</a> / New</div>
        <h2 class="page-title">Assign staff to counter</h2>
        <div class="page-sub">Assign a staff member to a payout schedule.</div>
    </div>
</div>

<form action="{{ route('staff-assignments.store') }}" method="POST">
    @csrf
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Schedule</div>
            <div class="form-grid">
                <div class="span-2">
                    <label class="form-label" for="schedule_id">Payout schedule</label>
                    <select name="schedule_id" id="schedule_id" class="form-select" required>
                        <option value="">Select schedule</option>
                        @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}">
                                {{ $schedule->cycle->cycle_name ?? '—' }} —
                                {{ $schedule->barangay->name ?? 'No barangay' }} —
                                {{ $schedule->scheduled_date }}
                            </option>
                        @endforeach
                    </select>
                    @error('schedule_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Staff and counter</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="user_id">Staff member</label>
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">Select staff</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="counter_id">Counter</label>
                    <select name="counter_id" id="counter_id" class="form-select" required>
                        <option value="">Select counter</option>
                        @foreach($counters as $counter)
                            <option value="{{ $counter->id }}">
                                {{ $counter->counter_number }}@if($counter->label) — {{ $counter->label }}@endif
                            </option>
                        @endforeach
                    </select>
                    @error('counter_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('staff-assignments.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save assignment</button>
        </div>
    </div>
</form>
@endsection
