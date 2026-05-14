@extends('layouts.app')
@section('content')
<div class="empty-state" style="padding: 5rem 1rem">
    <i class="bi bi-shield-lock d-block" style="font-size:3rem;color:#94a3b8;margin-bottom:1rem"></i>
    <h2 style="font-size:1.2rem;font-weight:600;margin-bottom:.5rem">Access Denied</h2>
    <p style="color:#64748b;font-size:.85rem;margin-bottom:1.5rem">
        You do not have permission to access this page.<br>
        Contact your administrator if you think this is a mistake.
    </p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">
        <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>
@endsection