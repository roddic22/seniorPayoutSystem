@extends('layouts.app')
@section('content')
<h2>Senior Citizen Details</h2>
<div class="card p-4">
    <p><strong>OSCA ID:</strong> {{ $senior->osca_id }}</p>
    <p><strong>Name:</strong> {{ $senior->name }}</p>
    <p><strong>Address:</strong> {{ $senior->address }}</p>
    <p><strong>Age:</strong> {{ $senior->age }}</p>
    <p><strong>Birthdate:</strong> {{ $senior->birthdate }}</p>
    <p><strong>Sex:</strong> {{ $senior->sex }}</p>
    <p><strong>Contact:</strong> {{ $senior->contact_number }}</p>
    <p><strong>Barangay:</strong> {{ $senior->barangay->name ?? 'N/A' }}</p>
    <p><strong>Status:</strong> {{ $senior->status }}</p>
</div>
<a href="{{ route('seniors.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection