@extends('layouts.app')
@section('content')
<h2>Edit Payout Cycle</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('payout-cycles.update', $payoutCycle) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Cycle Name</label>
            <input type="text" name="cycle_name" class="form-control"
                value="{{ $payoutCycle->cycle_name }}" required>
        </div>
        <div class="mb-3">
            <label>Period Start</label>
            <input type="date" name="period_start" class="form-control"
                value="{{ $payoutCycle->period_start }}" required>
        </div>
        <div class="mb-3">
            <label>Period End</label>
            <input type="date" name="period_end" class="form-control"
                value="{{ $payoutCycle->period_end }}" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="draft" {{ $payoutCycle->status === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="active" {{ $payoutCycle->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ $payoutCycle->status === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('payout-cycles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection