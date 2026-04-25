@extends('layouts.app')
@section('topbar-title', 'Edit cycle')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('payout-cycles.index') }}" class="text-muted text-decoration-none">Cycles</a> / Edit</div>
        <h2 class="page-title">Edit payout cycle</h2>
        <div class="page-sub">{{ $payoutCycle->cycle_name }}</div>
    </div>
</div>

<form action="{{ route('payout-cycles.update', $payoutCycle) }}" method="POST">
    @csrf @method('PUT')
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Cycle details</div>
            <div class="form-grid">
                <div class="span-2">
                    <label class="form-label" for="cycle_name">Cycle name</label>
                    <input type="text" name="cycle_name" id="cycle_name" class="form-control" value="{{ old('cycle_name', $payoutCycle->cycle_name) }}" required>
                </div>
                <div>
                    <label class="form-label" for="period_start">Period start</label>
                    <input type="date" name="period_start" id="period_start" class="form-control" value="{{ old('period_start', $payoutCycle->period_start) }}" required>
                </div>
                <div>
                    <label class="form-label" for="period_end">Period end</label>
                    <input type="date" name="period_end" id="period_end" class="form-control" value="{{ old('period_end', $payoutCycle->period_end) }}" required>
                </div>
                <div class="span-2">
                    <label class="form-label" for="status">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="draft" {{ $payoutCycle->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ $payoutCycle->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ $payoutCycle->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('payout-cycles.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>
@endsection
