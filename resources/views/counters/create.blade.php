@extends('layouts.app')
@section('content')
<h2>Add Counter</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('counters.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Counter Number</label>
            <input type="text" name="counter_number" class="form-control" placeholder="e.g. C-01" required>
            @error('counter_number')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Label <span class="text-muted">(optional)</span></label>
            <input type="text" name="label" class="form-control" placeholder="e.g. Senior A Counter">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('counters.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection