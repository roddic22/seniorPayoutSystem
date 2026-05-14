@extends('layouts.app')
@section('topbar-title', 'Staff Management')
@section('topbar-sub', 'Manage system users and roles')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Operations</div>
        <h1 class="page-title">Staff Members</h1>
    </div>
    <div class="page-actions">
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('staff.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i> Add Staff
        </a>
        @endif
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($staff as $member)
            <tr>
                <td>
                    <div style="font-weight:500">{{ $member->name }}</div>
                </td>
                <td style="color:#64748b">{{ $member->email }}</td>
                <td>
                    @if($member->role === 'admin')
                        <span class="pill pill-danger">Admin</span>
                    @elseif($member->role === 'staff')
                        <span class="pill pill-info">Staff</span>
                    @else
                        <span class="pill pill-muted">Clerk</span>
                    @endif
                </td>
                <td style="color:#64748b;font-size:.78rem">
                    {{ $member->created_at->format('M d, Y') }}
                </td>
                <td>
                    <div class="row-actions">
                        <a href="{{ route('staff.show', $member) }}"
                            class="row-action view" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('staff.edit', $member) }}"
                            class="row-action edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if($member->id !== auth()->id())
                        <form action="{{ route('staff.destroy', $member) }}"
                            method="POST" class="d-inline"
                            onsubmit="return confirm('Remove {{ $member->name }}?')">
                            @csrf @method('DELETE')
                            <button class="row-action delete" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="table-empty">No staff members yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $staff->links() }}
@endsection