@extends('layouts.app')
@section('topbar-title', 'Edit senior')
@section('content')

@if($errors->any())
<div class="alert alert-danger mb-3">
    <i class="bi bi-exclamation-triangle me-1"></i>
    Please fix the following errors:
    <ul class="mb-0 mt-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('seniors.index') }}" class="text-muted text-decoration-none">Seniors</a> / Edit</div>
        <h2 class="page-title">Edit senior citizen</h2>
        <div class="page-sub">Update {{ $senior->name }}'s record.</div>
    </div>
</div>

<form action="{{ route('seniors.update', $senior) }}" method="POST">
    @csrf @method('PUT')
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Identification</div>
            <div class="form-section-sub">OSCA registration details.</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="osca_id">OSCA ID</label>
                    <input type="text" name="osca_id" id="osca_id" class="form-control" value="{{ old('osca_id', $senior->osca_id) }}" required>
                    @error('osca_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="name">Full name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $senior->name) }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="span-2">
                    <label class="form-label" for="status">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', strtolower($senior->status ?? 'active')) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', strtolower($senior->status ?? '')) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="deceased" {{ old('status', strtolower($senior->status ?? '')) === 'deceased' ? 'selected' : '' }}>Deceased</option>
                    </select>
                    @error('status')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Personal details</div>
            <div class="form-section-sub">Age, sex and contact information.</div>
            <div class="form-grid">
                <div>
                    <label class="form-label" for="age">Age</label>
                    <input type="number" name="age" id="age" class="form-control" min="60" max="120" value="{{ old('age', $senior->age) }}" placeholder="Minimum age is 60" required>
                    <div class="form-hint">Must be between 60 and 120.</div>
                    @error('age')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="birthdate">Birthdate</label>
                    <input type="date" name="birthdate" id="birthdate" class="form-control" value="{{ old('birthdate', $senior->birthdate) }}">
                    @error('birthdate')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="sex">Sex</label>
                    <select name="sex" id="sex" class="form-select">
                        <option value="">Select</option>
                        <option value="male" {{ $senior->sex == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $senior->sex == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('sex')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="form-label" for="contact_number">Contact Number</label>
                    <input type="tel" name="contact_number" id="contact_number" class="form-control" value="{{ old('contact_number', $senior->contact_number) }}" placeholder="e.g. 09171234567" pattern="09[0-9]{9}" minlength="11" maxlength="11" inputmode="numeric" required>
                    <div class="form-hint">Must be exactly 11 digits and start with 09.</div>
                    @error('contact_number')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title">Address</div>
            <div class="form-section-sub">Where this senior resides.</div>
            <div class="form-grid">
                <div class="span-2">
                    <label class="form-label" for="address">Street address</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $senior->address) }}" required>
                    @error('address')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="span-2">
                    <label class="form-label" for="barangay_id">Barangay</label>
                    <select name="barangay_id" id="barangay_id" class="form-select">
                        <option value="">Select barangay</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->id }}" {{ $senior->barangay_id == $barangay->id ? 'selected' : '' }}>
                                {{ $barangay->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('barangay_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('seniors.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-lg me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check2 me-1"></i> Save changes
            </button>
        </div>
    </div>
</form>
@endsection
