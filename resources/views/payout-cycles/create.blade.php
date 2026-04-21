@extends('layouts.app')
@section('content')
<h2>Create Payout Cycle</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('payout-cycles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Cycle Name</label>
            <input type="text" name="cycle_name" class="form-control"
                placeholder="e.g. Q1 2025 Payout" required>
            @error('cycle_name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Period Start</label>
            <input type="date" name="period_start" class="form-control" required>
            @error('period_start')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Period End</label>
            <input type="date" name="period_end" class="form-control" required>
            @error('period_end')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="draft">Draft</option>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('payout-cycles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection