@extends('layouts.app')
@section('content')
<h2>Assign Staff to Counter</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('staff-assignments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Payout Schedule</label>
            <select name="schedule_id" class="form-control" required>
                <option value="">-- Select Schedule --</option>
                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}">
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
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Counter</label>
            <select name="counter_id" class="form-control" required>
                <option value="">-- Select Counter --</option>
                @foreach($counters as $counter)
                    <option value="{{ $counter->id }}">
                        {{ $counter->counter_number }}
                        @if($counter->label) — {{ $counter->label }} @endif
                    </option>
                @endforeach
            </select>
            @error('counter_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-success">Assign</button>
        <a href="{{ route('staff-assignments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection