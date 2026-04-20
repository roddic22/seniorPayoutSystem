@extends('layouts.app')
@section('content')
<h2>Edit Barangay</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('barangays.update', $barangay) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Barangay Name</label>
            <input type="text" name="name" class="form-control" value="{{ $barangay->name }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="{{ $barangay->city }}" required>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('barangays.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection