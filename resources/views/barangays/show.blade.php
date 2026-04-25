@extends('layouts.app')
@section('topbar-title', 'Barangay details')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('barangays.index') }}" class="text-muted text-decoration-none">Barangays</a> / {{ $barangay->name }}</div>
        <h2 class="page-title">{{ $barangay->name }}</h2>
        <div class="page-sub">{{ $barangay->city }}</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('barangays.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
        <a href="{{ route('barangays.edit', $barangay) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="kpi kpi-info">
            <div class="kpi-icon"><i class="bi bi-people"></i></div>
            <div class="kpi-label">Total seniors</div>
            <div class="kpi-value">{{ number_format($barangay->seniors()->count()) }}</div>
            <div class="kpi-foot">Registered in this barangay</div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="surface h-100">
            <div class="surface-body">
                <dl class="deflist">
                    <dt>Barangay</dt><dd>{{ $barangay->name }}</dd>
                    <dt>City</dt><dd>{{ $barangay->city }}</dd>
                    <dt>Total seniors</dt><dd>{{ $barangay->seniors()->count() }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="surface">
    <div class="surface-head">
        <h5>Seniors in this barangay</h5>
    </div>
    <table class="table mb-0">
        <thead>
            <tr>
                <th>OSCA ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($seniors as $senior)
                <tr>
                    <td class="text-muted">{{ $senior->osca_id }}</td>
                    <td class="fw-semibold">{{ $senior->name }}</td>
                    <td>{{ $senior->age }}</td>
                    <td>
                        @if($senior->status === 'active' || $senior->status === 'Active')
                            <span class="pill pill-success">Active</span>
                        @elseif($senior->status === 'deceased' || $senior->status === 'Deceased')
                            <span class="pill pill-danger">Deceased</span>
                        @else
                            <span class="pill pill-muted">{{ ucfirst($senior->status ?? '—') }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="table-empty">No seniors registered in this barangay yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $seniors->links() }}
</div>
@endsection
