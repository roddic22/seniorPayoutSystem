@extends('layouts.app')
@section('topbar-title', 'New senior')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('seniors.index') }}" class="text-muted text-decoration-none">Seniors</a> / New</div>
        <h2 class="page-title">Register senior citizen</h2>
        <div class="page-sub">Add a new senior to the master roll.</div>
    </div>
</div>

<form action="{{ route('seniors.store') }}" method="POST">
    @csrf
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Identification</div>
            <div class="form-section-sub">OSCA registration details.</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="osca_id">OSCA ID</label>
                    <input type="text" name="osca_id" id="osca_id" class="form-control" value="{{ old('osca_id') }}" required>
                    @error('osca_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="name">Full name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Personal details</div>
            <div class="form-section-sub">Age, sex and contact information.</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="age">Age</label>
                    <input type="number" name="age" id="age" class="form-control" min="60" value="{{ old('age') }}" required>
                </div>
                <div>
                    <label class="form-label" for="birthdate">Birthdate</label>
                    <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{ old('birthdate') }}">
                </div>
                <div>
                    <label class="form-label" for="sex">Sex</label>
                    <select name="sex" id="sex" class="form-select">
                        <option value="">Select</option>
                        <option value="male" {{ old('sex') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('sex') === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="contact_number">Contact number</label>
                    <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ old('contact_number') }}" placeholder="09xx xxx xxxx">
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Address</div>
            <div class="form-section-sub">Where this senior resides.</div>
            <div class="form-grid">
                <div class="span-2">
                    <label class="form-label" for="address">Street address</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}" required>
                </div>
                <div class="span-2">
                    <label class="form-label" for="barangay_id">Barangay</label>
                    <select name="barangay_id" id="barangay_id" class="form-select">
                        <option value="">Select barangay</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->id }}" {{ old('barangay_id') == $barangay->id ? 'selected' : '' }}>
                                {{ $barangay->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('seniors.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save senior</button>
        </div>
    </div>
</form>
@endsection
