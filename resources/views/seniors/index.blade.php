@extends('layouts.app')
@section('topbar-title', 'Seniors')

@push('head')
<style>
    .senior-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .85rem;
        margin-bottom: 1rem;
    }

    .senior-stat {
        background: var(--c-surface);
        border: 1px solid var(--c-line);
        border-radius: var(--radius-lg);
        padding: 1rem;
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
    }

    .senior-stat::after {
        content: '';
        position: absolute;
        inset: 0 0 auto;
        height: 3px;
        background: var(--stat-color, var(--c-primary-600));
    }

    .senior-stat-label {
        color: var(--c-muted);
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: .35rem;
    }

    .senior-stat-value {
        color: var(--c-ink);
        font-size: 1.45rem;
        font-weight: 700;
        line-height: 1;
    }

    .senior-name {
        display: flex;
        flex-direction: column;
        gap: .12rem;
        min-width: 180px;
    }

    .senior-name-main {
        color: var(--c-ink);
        font-weight: 600;
    }

    .senior-name-sub {
        color: var(--c-muted);
        font-size: .72rem;
    }

    .barangay-filter {
        background: var(--c-surface);
        border: 1px solid var(--c-line);
        border-radius: var(--radius-lg);
        padding: 1rem;
        box-shadow: var(--shadow-sm);
        margin-bottom: 1rem;
    }

    .barangay-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .75rem;
        margin-bottom: 1rem;
        transition: grid-template-columns .24s ease;
    }

    .barangay-grid.focused {
        grid-template-columns: minmax(0, 420px);
    }

    .barangay-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        padding: .85rem;
        border: 1px solid var(--c-line);
        border-radius: var(--radius-lg);
        background: var(--c-surface);
        color: var(--c-ink);
        text-decoration: none;
        box-shadow: var(--shadow-sm);
        opacity: 0;
        transform: translateY(8px);
        animation: barangayEnter .28s ease forwards;
        transition: background .18s ease, border-color .18s ease, transform .18s ease, box-shadow .18s ease, opacity .18s ease;
    }

    .barangay-card:hover {
        background: #f8fafc;
        border-color: #bfdbfe;
        color: var(--c-ink);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .barangay-card.active {
        background: var(--c-primary-50);
        border-color: #93c5fd;
        box-shadow: inset 3px 0 0 var(--c-primary-600);
    }

    .barangay-card:active {
        transform: translateY(0);
    }

    .barangay-card.is-opening {
        opacity: .55;
        transform: scale(.98);
    }

    .barangay-card.active .barangay-card-city::after {
        content: 'Open barangay';
        display: block;
        color: var(--c-primary-600);
        font-weight: 600;
        margin-top: .15rem;
    }

    .barangay-card-name {
        display: block;
        font-size: .82rem;
        font-weight: 600;
        line-height: 1.25;
    }

    .barangay-card-city {
        display: block;
        margin-top: .1rem;
        color: var(--c-muted);
        font-size: .7rem;
    }

    .barangay-count {
        display: inline-grid;
        place-items: center;
        min-width: 30px;
        height: 28px;
        border-radius: 999px;
        background: #f1f5f9;
        color: var(--c-ink-2);
        font-size: .75rem;
        font-weight: 700;
        padding: 0 .5rem;
        flex: 0 0 auto;
    }

    .selected-barangay-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: .75rem;
        flex-wrap: wrap;
        animation: barangayEnter .28s ease both;
    }

    .selected-barangay-title {
        margin: 0;
        font-size: .95rem;
        font-weight: 700;
    }

    .selected-barangay-sub {
        color: var(--c-muted);
        font-size: .78rem;
    }

    .senior-empty {
        padding: 3.5rem 1rem !important;
        text-align: center;
    }

    .senior-empty-icon {
        display: inline-grid;
        place-items: center;
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--c-primary-50);
        color: var(--c-primary-600);
        margin-bottom: .75rem;
        font-size: 1.2rem;
    }

    .senior-empty h5 {
        margin: 0 0 .25rem;
        font-size: .95rem;
    }

    .senior-empty p {
        margin: 0 0 1rem;
        color: var(--c-muted);
        font-size: .82rem;
    }

    .senior-results-panel {
        animation: barangayEnter .3s ease both;
    }

    @keyframes barangayEnter {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .barangay-card,
        .selected-barangay-head,
        .senior-results-panel {
            animation: none;
            opacity: 1;
            transform: none;
        }
    }

    @media (max-width: 991.98px) {
        .senior-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .barangay-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .barangay-grid.focused { grid-template-columns: minmax(0, 1fr); }
    }

    @media (max-width: 575.98px) {
        .senior-summary { grid-template-columns: 1fr; }
        .barangay-grid { grid-template-columns: 1fr; }
        .barangay-grid.focused { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="page-head">
    <div>
        <div class="page-eyebrow">Records</div>
        <h2 class="page-title">Senior citizens</h2>
        <div class="page-sub">
            @if($selectedBarangay)
                Viewing recorded seniors for {{ $selectedBarangay->name }}.
            @else
                Browse registered seniors by barangay to keep the list focused.
            @endif
        </div>
    </div>
    <div class="page-actions">
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('seniors.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add senior
        </a>
        @endif
    </div>
</div>

<div class="barangay-filter">
    <form method="GET" action="{{ route('seniors.index') }}" class="row g-2 align-items-end">
        <div class="col-md-5">
            <label for="search" class="form-label">Search by senior name</label>
            <div
                class="expanding-search {{ $search !== '' ? 'is-open' : '' }}"
                data-clear-url="{{ $selectedBarangayId ? route('seniors.index', ['barangay_id' => $selectedBarangayId]) : route('seniors.index') }}"
                data-expanding-search
            >
                <input
                    type="search"
                    name="search"
                    id="search"
                    class="expanding-search-input"
                    value="{{ $search }}"
                    placeholder="Search"
                    aria-label="Search by senior name"
                    data-expanding-search-input
                >
                <button type="submit" class="expanding-search-btn" aria-label="Search" data-expanding-search-button>
                    <i class="bi bi-search"></i>
                </button>
                <button type="button" class="expanding-search-close" aria-label="Close search" data-expanding-search-close>
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <label for="barangay_id" class="form-label">View records by barangay</label>
            <select name="barangay_id" id="barangay_id" class="form-select">
                <option value="">All barangays</option>
                @foreach($barangays as $barangay)
                    <option value="{{ $barangay->id }}" {{ (string) $selectedBarangayId === (string) $barangay->id ? 'selected' : '' }}>
                        {{ $barangay->name }} ({{ $barangay->seniors_count }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-grid">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search me-1"></i> Search
            </button>
        </div>
    </form>
    @if($search !== '' || $selectedBarangay)
        <div class="mt-2">
            <a href="{{ route('seniors.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-x-lg me-1"></i> Clear filters
            </a>
        </div>
    @endif
</div>

<div class="senior-summary">
    <div class="senior-stat">
        <div class="senior-stat-label">Total records</div>
        <div class="senior-stat-value">{{ number_format($seniorStats['total'] ?? 0) }}</div>
    </div>
    <div class="senior-stat" style="--stat-color: var(--c-success);">
        <div class="senior-stat-label">Active</div>
        <div class="senior-stat-value">{{ number_format($seniorStats['active'] ?? 0) }}</div>
    </div>
    <div class="senior-stat" style="--stat-color: #64748b;">
        <div class="senior-stat-label">Inactive</div>
        <div class="senior-stat-value">{{ number_format($seniorStats['inactive'] ?? 0) }}</div>
    </div>
    <div class="senior-stat" style="--stat-color: var(--c-danger);">
        <div class="senior-stat-label">Deceased</div>
        <div class="senior-stat-value">{{ number_format($seniorStats['deceased'] ?? 0) }}</div>
    </div>
</div>

<div class="barangay-grid {{ $selectedBarangay ? 'focused' : '' }}">
    @forelse($barangays as $barangay)
        @if(!$selectedBarangay || (string) $selectedBarangayId === (string) $barangay->id)
        <a href="{{ route('seniors.index', ['barangay_id' => $barangay->id]) }}"
            class="barangay-card {{ (string) $selectedBarangayId === (string) $barangay->id ? 'active' : '' }}"
            data-barangay-card
            style="animation-delay: {{ $loop->index * 35 }}ms">
            <span>
                <span class="barangay-card-name">{{ $barangay->name }}</span>
                <span class="barangay-card-city">{{ $barangay->city ?: 'Barangay records' }}</span>
            </span>
            <span class="barangay-count">{{ $barangay->seniors_count }}</span>
        </a>
        @endif
    @empty
        <div class="surface surface-pad text-muted">No barangays available yet.</div>
    @endforelse
</div>

@if($seniors)
    <div class="senior-results-panel">
    <div class="selected-barangay-head">
        <div>
            <h3 class="selected-barangay-title">
                @if($selectedBarangay)
                    {{ $selectedBarangay->name }} seniors
                @else
                    Search results
                @endif
            </h3>
            <div class="selected-barangay-sub">
                @if($search !== '' && $selectedBarangay)
                    Showing names containing "{{ $search }}" under {{ $selectedBarangay->name }}.
                @elseif($search !== '')
                    Showing names containing "{{ $search }}" across all barangays.
                @else
                    Showing records registered under this barangay only.
                @endif
            </div>
        </div>
        <a href="{{ route('seniors.index') }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-grid me-1"></i> Barangay overview
        </a>
    </div>

    <div class="table-wrap">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>OSCA ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($seniors as $senior)
                        <tr>
                            <td><span class="text-muted">{{ $senior->osca_id }}</span></td>
                            <td>
                                <div class="senior-name">
                                    <span class="senior-name-main">{{ $senior->name }}</span>
                                    <span class="senior-name-sub">{{ $senior->contact_number ?: 'No contact number' }}</span>
                                </div>
                            </td>
                            <td>{{ $senior->age }}</td>
                            <td>
                                @if($senior->status === 'active' || $senior->status === 'Active')
                                    <span class="pill pill-success">Active</span>
                                @elseif($senior->status === 'inactive' || $senior->status === 'Inactive')
                                    <span class="pill pill-muted">Inactive</span>
                                @elseif($senior->status === 'deceased' || $senior->status === 'Deceased')
                                    <span class="pill pill-danger">Deceased</span>
                                @else
                                    <span class="pill pill-muted">{{ ucfirst($senior->status ?? '-') }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="row-actions">
                                    <a href="{{ route('seniors.show', $senior) }}" class="row-action view" title="View" aria-label="View senior"><i class="bi bi-eye"></i></a>
                                    @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('seniors.edit', $senior) }}" class="row-action edit" title="Edit" aria-label="Edit senior"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('seniors.destroy', $senior) }}" method="POST"
                                        onsubmit="return confirm('Delete this senior record?')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="row-action delete" title="Delete" aria-label="Delete senior"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="senior-empty">
                                <div class="senior-empty-icon"><i class="bi bi-people"></i></div>
                                <h5>No matching seniors found</h5>
                                <p>Try another name or choose a different barangay.</p>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('seniors.create') }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-lg me-1"></i> Add senior
                                </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $seniors->links() }}
    </div>
    </div>
@else
    <div class="surface">
        <div class="senior-empty">
            <div class="senior-empty-icon"><i class="bi bi-geo-alt"></i></div>
            <h5>Select a barangay to view senior records</h5>
            <p>Use the barangay cards or the selector above to load only that barangay's registered seniors.</p>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-barangay-card]').forEach(function (card) {
        card.addEventListener('click', function () {
            card.classList.add('is-opening');
        });
    });
</script>
@endpush
