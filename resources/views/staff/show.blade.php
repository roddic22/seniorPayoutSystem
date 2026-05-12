@extends('layouts.app')
@section('topbar-title', 'Staff Details')
@section('topbar-sub', 'View staff profile and assignments')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Staff</div>
        <h1 class="page-title">{{ $staff->name }}</h1>
    </div>
    <div class="page-actions">
        <a href="{{ route('staff.edit', $staff) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('staff.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="surface surface-pad">
            <dl class="deflist">
                <dt>Name</dt><dd>{{ $staff->name }}</dd>
                <dt>Email</dt><dd>{{ $staff->email }}</dd>
                <dt>Role</dt>
                <dd>
                    @if($staff->role === 'admin')
                        <span class="pill pill-danger">Admin</span>
                    @elseif($staff->role === 'staff')
                        <span class="pill pill-info">Staff</span>
                    @else
                        <span class="pill pill-muted">Clerk</span>
                    @endif
                </dd>
                <dt>Registered</dt>
                <dd>{{ $staff->created_at->format('M d, Y') }}</dd>
            </dl>
        </div>
    </div>
    <div class="col-md-8">
        <div class="surface">
            <div class="surface-head">
                <h5>Counter Assignments</h5>
                <span class="text-muted" style="font-size:.75rem">
                    {{ $assignments->count() }} total
                </span>
            </div>
            <div class="surface-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cycle</th>
                            <th>Barangay</th>
                            <th>Date</th>
                            <th>Counter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $a)
                        <tr>
                            <td>{{ $a->schedule->cycle->cycle_name ?? '—' }}</td>
                            <td>{{ $a->schedule->barangay->name ?? '—' }}</td>
                            <td>{{ $a->schedule->scheduled_date ?? '—' }}</td>
                            <td>{{ $a->counter->counter_number ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="table-empty">No assignments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection