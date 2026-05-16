@extends('layouts.app')
@section('topbar-title', 'Assign Staff')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Operations</div>
        <h2 class="page-title">Assign staff to counter</h2>
    </div>
    <div class="page-actions">
        <a href="{{ route('staff-assignments.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

@if(session('assignment_error'))
<div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
    <i class="bi bi-exclamation-triangle-fill"></i>
    {{ session('assignment_error') }}
</div>
@endif

<div class="surface" style="max-width:560px">
    <form action="{{ route('staff-assignments.store') }}" method="POST">
        @csrf
        <div class="form-section">
            <div class="form-section-title">Assignment Details</div>
            <div class="mb-3">
                <label class="form-label">Payout Schedule</label>
                <select name="schedule_id" class="form-select" required>
                    <option value="">-- Select Schedule --</option>
                    @foreach($schedules as $schedule)
                        <option value="{{ $schedule->id }}"
                            {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                            {{ $schedule->cycle->cycle_name ?? '—' }} —
                            {{ $schedule->barangay->name ?? 'No Barangay' }} —
                            {{ $schedule->scheduled_date }}
                        </option>
                    @endforeach
                </select>
                @error('schedule_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Staff Member</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Select Staff --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                            ({{ ucfirst($user->role) }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Counter</label>
                <select name="counter_id" class="form-select" required>
                    <option value="">-- Select Counter --</option>
                    @foreach($counters as $counter)
                        <option value="{{ $counter->id }}"
                            {{ old('counter_id') == $counter->id ? 'selected' : '' }}>
                            {{ $counter->counter_number }}
                            @if($counter->label) — {{ $counter->label }} @endif
                        </option>
                    @endforeach
                </select>
                @error('counter_id')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('staff-assignments.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-check me-1"></i> Assign
            </button>
        </div>
    </form>
</div>
@endsection