@extends('layouts.app')
@section('topbar-title', 'New barangay')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('barangays.index') }}" class="text-muted text-decoration-none">Barangays</a> / New</div>
        <h2 class="page-title">Add barangay</h2>
        <div class="page-sub">Define a new service area.</div>
    </div>
</div>

<form action="{{ route('barangays.store') }}" method="POST">
    @csrf
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Barangay information</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="name">Barangay name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="city">City</label>
                    <input type="text" name="city" id="city" class="form-control" value="{{ old('city', 'Davao City') }}" required>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('barangays.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save barangay</button>
        </div>
    </div>
</form>
@endsection
