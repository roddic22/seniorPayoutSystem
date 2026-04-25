@extends('layouts.app')
@section('topbar-title', 'New cycle')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('payout-cycles.index') }}" class="text-muted text-decoration-none">Cycles</a> / New</div>
        <h2 class="page-title">Create payout cycle</h2>
        <div class="page-sub">Define a new disbursement period.</div>
    </div>
</div>

<form action="{{ route('payout-cycles.store') }}" method="POST">
    @csrf
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Cycle details</div>
            <div class="form-grid">
                <div class="span-2">
                    <label class="form-label" for="cycle_name">Cycle name</label>
                    <input type="text" name="cycle_name" id="cycle_name" class="form-control" placeholder="e.g. Q1 2026 payout" value="{{ old('cycle_name') }}" required>
                    @error('cycle_name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="period_start">Period start</label>
                    <input type="date" name="period_start" id="period_start" class="form-control" value="{{ old('period_start') }}" required>
                    @error('period_start')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="period_end">Period end</label>
                    <input type="date" name="period_end" id="period_end" class="form-control" value="{{ old('period_end') }}" required>
                    @error('period_end')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="span-2">
                    <label class="form-label" for="status">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="draft">Draft</option>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                    </select>
                    <div class="form-hint">Drafts are not visible to payout staff until activated.</div>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('payout-cycles.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save cycle</button>
        </div>
    </div>
</form>
@endsection
