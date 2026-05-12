@extends('layouts.app')
@section('topbar-title', 'Add Staff')
@section('topbar-sub', 'Create a new staff account')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Staff</div>
        <h1 class="page-title">Add Staff Member</h1>
    </div>
    <div class="page-actions">
        <a href="{{ route('staff.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<div class="surface" style="max-width:560px">
    <form action="{{ route('staff.store') }}" method="POST">
        @csrf
        <div class="form-section">
            <div class="form-section-title">Account Information</div>
            <div class="form-section-sub">This account will be used to log in to the system.</div>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name') }}" placeholder="e.g. Juan Dela Cruz" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email') }}" placeholder="e.g. juan@example.com" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Select Role --</option>
                    <option value="admin"  {{ old('role') == 'admin'  ? 'selected' : '' }}>Admin</option>
                    <option value="staff"  {{ old('role') == 'staff'  ? 'selected' : '' }}>Staff</option>
                    <option value="clerk"  {{ old('role') == 'clerk'  ? 'selected' : '' }}>Clerk</option>
                </select>
                @error('role')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                    placeholder="Minimum 6 characters" required>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('staff.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Add Staff
            </button>
        </div>
    </form>
</div>
@endsection