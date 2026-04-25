@extends('layouts.app')
@section('topbar-title', 'Edit barangay')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('barangays.index') }}" class="text-muted text-decoration-none">Barangays</a> / Edit</div>
        <h2 class="page-title">Edit barangay</h2>
        <div class="page-sub">Update {{ $barangay->name }}.</div>
    </div>
</div>

<form action="{{ route('barangays.update', $barangay) }}" method="POST">
    @csrf @method('PUT')
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Barangay information</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="name">Barangay name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $barangay->name) }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="city">City</label>
                    <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $barangay->city) }}" required>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('barangays.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>
@endsection
