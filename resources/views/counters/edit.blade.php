@extends('layouts.app')
@section('content')
<h2>Edit Counter</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('counters.update', $counter) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Counter Number</label>
            <input type="text" name="counter_number" class="form-control" value="{{ $counter->counter_number }}" required>
            @error('counter_number')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Label</label>
            <input type="text" name="label" class="form-control" value="{{ $counter->label }}">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
                {{ $counter->is_active ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('counters.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection