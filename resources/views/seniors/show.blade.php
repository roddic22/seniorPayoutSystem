@extends('layouts.app')
@section('topbar-title', 'Senior details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('seniors.index') }}" class="text-muted text-decoration-none">Seniors</a> / {{ $senior->osca_id }}</div>
        <h2 class="page-title">{{ $senior->name }}</h2>
        <div class="page-sub">OSCA ID {{ $senior->osca_id }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('seniors.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <a href="{{ route('seniors.edit', $senior) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Profile</h5>
        @if($senior->status === 'active' || $senior->status === 'Active')
            <span class="pill pill-success">Active</span>
        @elseif($senior->status === 'inactive' || $senior->status === 'Inactive')
            <span class="pill pill-muted">Inactive</span>
        @elseif($senior->status === 'deceased' || $senior->status === 'Deceased')
            <span class="pill pill-danger">Deceased</span>
        @else
            <span class="pill pill-muted">{{ ucfirst($senior->status ?? '-') }}</span>
        @endif
    </div>
    <div class="surface-body">
        <dl class="deflist">
            <dt>OSCA ID</dt><dd>{{ $senior->osca_id }}</dd>
            <dt>Full name</dt><dd>{{ $senior->name }}</dd>
            <dt>Age</dt><dd>{{ $senior->age }}</dd>
            <dt>Birthdate</dt><dd>{{ $senior->birthdate ?? '-' }}</dd>
            <dt>Sex</dt><dd>{{ $senior->sex ? ucfirst($senior->sex) : '-' }}</dd>
            <dt>Contact</dt><dd>{{ $senior->contact_number ?? '-' }}</dd>
            <dt>Address</dt><dd>{{ $senior->address }}</dd>
            <dt>Barangay</dt><dd>{{ $senior->barangay->name ?? '-' }}</dd>
        </dl>
    </div>
</div>
@endsection
