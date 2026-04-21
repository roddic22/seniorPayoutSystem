@extends('layouts.app')
@section('content')
<h2>Create Payout Schedule</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('payout-schedules.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Payout Cycle</label>
            <select name="cycle_id" class="form-control" required>
                <option value="">-- Select Active Cycle --</option>
                @foreach($cycles as $cycle)
                    <option value="{{ $cycle->id }}">{{ $cycle->cycle_name }}</option>
                @endforeach
            </select>
            @error('cycle_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Barangay</label>
            <select name="barangay_id" class="form-control">
                <option value="">-- Select Barangay --</option>
                @foreach($barangays as $barangay)
                    <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Scheduled Date</label>
            <input type="date" name="scheduled_date" class="form-control" required>
            @error('scheduled_date')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Time Start</label>
                <input type="time" name="time_start" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label>Time End</label>
                <input type="time" name="time_end" class="form-control">
            </div>
        </div>
        <div class="mb-3">
            <label>Venue</label>
            <input type="text" name="venue" class="form-control" placeholder="e.g. Barangay Hall">
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('payout-schedules.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection