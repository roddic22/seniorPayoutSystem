@extends('layouts.app')
@section('content')
<h2>Edit Staff Assignment</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('staff-assignments.update', $staffAssignment) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Payout Schedule</label>
            <select name="schedule_id" class="form-control" required>
                <option value="">-- Select Schedule --</option>
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}"
                        {{ $staffAssignment->schedule_id == $schedule->id ? 'selected' : '' }}>
                        {{ $schedule->cycle->cycle_name ?? '—' }} —
                        {{ $schedule->barangay->name ?? 'No Barangay' }} —
                        {{ $schedule->scheduled_date }}
                    </option>
                @endforeach
            </select>
            @error('schedule_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Staff Member</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Select Staff --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ $staffAssignment->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Counter</label>
            <select name="counter_id" class="form-control" required>
                <option value="">-- Select Counter --</option>
                @foreach($counters as $counter)
                    <option value="{{ $counter->id }}"
                        {{ $staffAssignment->counter_id == $counter->id ? 'selected' : '' }}>
                        {{ $counter->counter_number }}
                        @if($counter->label) — {{ $counter->label }} @endif
                    </option>
                @endforeach
            </select>
            @error('counter_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('staff-assignments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection