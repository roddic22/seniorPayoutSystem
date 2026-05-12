@extends('layouts.app')
@section('topbar-title', 'Edit Staff')
@section('topbar-sub', 'Update staff account details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Staff</div>
        <h1 class="page-title">Edit: {{ $staff->name }}</h1>
    </div>
    <div class="page-actions">
        <a href="{{ route('staff.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</div>

<div class="surface" style="max-width:560px">
    <form action="{{ route('staff.update', $staff) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-section">
            <div class="form-section-title">Account Information</div>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control"
                    value="{{ $staff->name }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control"
                    value="{{ $staff->email }}" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $staff->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ $staff->role == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="clerk" {{ $staff->role == 'clerk' ? 'selected' : '' }}>Clerk</option>
                </select>
            </div>
        </div>
        <div class="form-section">
            <div class="form-section-title">Change Password</div>
            <div class="form-section-sub">Leave blank to keep the current password.</div>
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control"
                    placeholder="Minimum 6 characters">
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        </div>
        <div class="form-footer">
            <a href="{{ route('staff.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i> Update
            </button>
        </div>
    </form>
</div>
@endsection