@extends('layouts.app')
@section('content')
<h2>Edit Senior Citizen</h2>
<form action="{{ route('seniors.update', $senior) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>OSCA ID</label>
        <input type="text" name="osca_id" class="form-control" value="{{ $senior->osca_id }}" required>
    </div>
    <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="name" class="form-control" value="{{ $senior->name }}" required>
    </div>
    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" class="form-control" value="{{ $senior->address }}" required>
    </div>
    <div class="mb-3">
        <label>Age</label>
        <input type="number" name="age" class="form-control" value="{{ $senior->age }}" min="60" required>
    </div>
    <div class="mb-3">
        <label>Birthdate</label>
        <input type="date" name="birthdate" class="form-control" value="{{ $senior->birthdate }}">
    </div>
    <div class="mb-3">
        <label>Sex</label>
        <select name="sex" class="form-control">
            <option value="">-- Select --</option>
            <option value="male" {{ $senior->sex == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ $senior->sex == 'female' ? 'selected' : '' }}>Female</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Contact Number</label>
        <input type="text" name="contact_number" class="form-control" value="{{ $senior->contact_number }}">
    </div>
    <div class="mb-3">
        <label>Barangay</label>
        <select name="barangay_id" class="form-control">
            <option value="">-- Select Barangay --</option>
            @foreach($barangays as $barangay)
                <option value="{{ $barangay->id }}" {{ $senior->barangay_id == $barangay->id ? 'selected' : '' }}>
                    {{ $barangay->name }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
    <a href="{{ route('seniors.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection