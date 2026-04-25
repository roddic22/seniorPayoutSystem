@extends('layouts.app')
@section('topbar-title', 'Edit counter')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('counters.index') }}" class="text-muted text-decoration-none">Counters</a> / Edit</div>
        <h2 class="page-title">Edit counter</h2>
    </div>
</div>

<form action="{{ route('counters.update', $counter) }}" method="POST">
    @csrf @method('PUT')
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Counter information</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="counter_number">Counter number</label>
                    <input type="text" name="counter_number" id="counter_number" class="form-control" value="{{ old('counter_number', $counter->counter_number) }}" required>
                    @error('counter_number')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="label">Label</label>
                    <input type="text" name="label" id="label" class="form-control" value="{{ old('label', $counter->label) }}">
                </div>
                <div class="span-2">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ $counter->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Counter is active</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('counters.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>
@endsection
