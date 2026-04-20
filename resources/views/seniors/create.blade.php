@extends('layouts.app')
@section('content')
<h2>Register Senior Citizen</h2>
<form action="{{ route('seniors.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>OSCA ID</label>
        <input type="text" name="osca_id" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Age</label>
        <input type="number" name="age" class="form-control" min="60" required>
    </div>
    <div class="mb-3">
        <label>Birthdate</label>
        <input type="date" name="birthdate" class="form-control">
    </div>
    <div class="mb-3">
        <label>Sex</label>
        <select name="sex" class="form-control">
            <option value="">-- Select --</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Contact Number</label>
        <input type="text" name="contact_number" class="form-control">
    </div>
    <div class="mb-3">
        <label>Barangay</label>
        <select name="barangay_id" class="form-control">
            <option value="">-- Select Barangay --</option>
            @foreach($barangays as $barangay)
                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('seniors.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection