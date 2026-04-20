@extends('layouts.app')
@section('content')
<h2>Add Barangay</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('barangays.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Barangay Name</label>
            <input type="text" name="name" class="form-control" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="Davao City" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('barangays.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection