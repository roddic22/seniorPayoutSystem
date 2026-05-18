@extends('layouts.app')
@section('topbar-title', 'Document submissions')

@push('head')
<style>
    .submission-filter {
        background: var(--c-surface);
        border: 1px solid var(--c-line);
        border-radius: var(--radius-lg);
        padding: 1rem;
        box-shadow: var(--shadow-sm);
        margin-bottom: 1rem;
    }

    .submission-barangay-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .75rem;
        margin-bottom: 1rem;
        transition: grid-template-columns .24s ease;
    }

    .submission-barangay-grid.focused {
        grid-template-columns: minmax(0, 420px);
    }

    .submission-barangay-card {
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
        animation: submissionEnter .28s ease forwards;
        transition: background .18s ease, border-color .18s ease, transform .18s ease, box-shadow .18s ease, opacity .18s ease;
    }

    .submission-barangay-card:hover {
        background: #f8fafc;
        border-color: #bfdbfe;
        color: var(--c-ink);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .submission-barangay-card.active {
        background: var(--c-primary-50);
        border-color: #93c5fd;
        box-shadow: inset 3px 0 0 var(--c-primary-600);
    }

    .submission-barangay-card.is-opening {
        opacity: .55;
        transform: scale(.98);
    }

    .submission-barangay-name {
        display: block;
        font-size: .82rem;
        font-weight: 600;
        line-height: 1.25;
    }

    .submission-barangay-city {
        display: block;
        margin-top: .1rem;
        color: var(--c-muted);
        font-size: .7rem;
    }

    .submission-count {
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

    .submission-results-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: .75rem;
        flex-wrap: wrap;
        animation: submissionEnter .28s ease both;
    }

    .submission-results-title {
        margin: 0;
        font-size: .95rem;
        font-weight: 700;
    }

    .submission-results-sub {
        color: var(--c-muted);
        font-size: .78rem;
    }

    @keyframes submissionEnter {
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
        .submission-barangay-card,
        .submission-results-head {
            animation: none;
            opacity: 1;
            transform: none;
        }
    }

    @media (max-width: 991.98px) {
        .submission-barangay-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .submission-barangay-grid.focused { grid-template-columns: minmax(0, 1fr); }
    }

    @media (max-width: 575.98px) {
        .submission-barangay-grid,
        .submission-barangay-grid.focused { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="page-head">
    <div>
        <div class="page-eyebrow">Operations</div>
        <h2 class="page-title">Document submissions</h2>
        <div class="page-sub">
            @if($selectedBarangay)
                Viewing submitted requirements for {{ $selectedBarangay->name }}.
            @else
                Track submitted requirements by barangay and transaction.
            @endif
        </div>
    </div>
    <div class="page-actions">
        <a href="{{ route('document-submissions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add submission
        </a>
    </div>
</div>

<div class="submission-filter">
    <form method="GET" action="{{ route('document-submissions.index') }}" class="row g-2 align-items-end">
        <div class="col-md-5">
            <label for="search" class="form-label">Search submissions</label>
            <div
                class="expanding-search {{ $search !== '' ? 'is-open' : '' }}"
                data-clear-url="{{ $selectedBarangayId ? route('document-submissions.index', ['barangay_id' => $selectedBarangayId]) : route('document-submissions.index') }}"
                data-expanding-search
            >
                <input
                    type="search"
                    name="search"
                    id="search"
                    class="expanding-search-input"
                    value="{{ $search }}"
                    placeholder="Search"
                    aria-label="Search submissions"
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
            <label for="barangay_id" class="form-label">View by barangay</label>
            <select name="barangay_id" id="barangay_id" class="form-select">
                <option value="">All barangays</option>
                @foreach($barangays as $barangay)
                    <option value="{{ $barangay->id }}" {{ (string) $selectedBarangayId === (string) $barangay->id ? 'selected' : '' }}>
                        {{ $barangay->name }} ({{ $barangay->submissions_count }})
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
        <div class="mt-2 d-flex gap-2 flex-wrap">
            @if($selectedBarangay)
                <a href="{{ route('document-submissions.index', $search !== '' ? ['search' => $search] : []) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-grid me-1"></i> All barangays
                </a>
            @endif
            @if($search !== '')
                <a href="{{ $selectedBarangayId ? route('document-submissions.index', ['barangay_id' => $selectedBarangayId]) : route('document-submissions.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-x-lg me-1"></i> Clear search
                </a>
            @endif
            <a href="{{ route('document-submissions.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    @endif
</div>

<div class="submission-barangay-grid {{ $selectedBarangay ? 'focused' : '' }}">
    @forelse($barangays as $barangay)
        @if(!$selectedBarangay || (string) $selectedBarangayId === (string) $barangay->id)
        <a href="{{ route('document-submissions.index', ['barangay_id' => $barangay->id] + ($search !== '' ? ['search' => $search] : [])) }}"
            class="submission-barangay-card {{ (string) $selectedBarangayId === (string) $barangay->id ? 'active' : '' }}"
            data-submission-barangay-card
            style="animation-delay: {{ $loop->index * 35 }}ms">
            <span>
                <span class="submission-barangay-name">{{ $barangay->name }}</span>
                <span class="submission-barangay-city">{{ $barangay->city ?: 'Document submissions' }}</span>
            </span>
            <span class="submission-count">{{ $barangay->submissions_count }}</span>
        </a>
        @endif
    @empty
        <div class="surface surface-pad text-muted">No barangays available yet.</div>
    @endforelse
</div>

<div class="submission-results-head">
    <div>
        <h3 class="submission-results-title">
            @if($selectedBarangay)
                {{ $selectedBarangay->name }} submissions
            @elseif($search !== '')
                Search results
            @else
                All submissions
            @endif
        </h3>
        <div class="submission-results-sub">
            @if($search !== '' && $selectedBarangay)
                Showing records matching "{{ $search }}" under {{ $selectedBarangay->name }}.
            @elseif($search !== '')
                Showing records matching "{{ $search }}" across all barangays.
            @elseif($selectedBarangay)
                Showing submitted requirements under this barangay.
            @else
                Showing all submitted requirement records.
            @endif
        </div>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Transaction</th>
                <th>Senior</th>
                <th>Barangay</th>
                <th>Cycle</th>
                <th>Document</th>
                <th>Submitted</th>
                <th>Notes</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $submission)
                <tr>
                    <td class="text-muted">#{{ $submission->transaction_id }}</td>
                    <td>
                        <div class="fw-semibold">{{ $submission->transaction->senior->name ?? '-' }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $submission->transaction->senior->osca_id ?? '-' }}</div>
                    </td>
                    <td>{{ $submission->transaction->senior->barangay->name ?? '-' }}</td>
                    <td class="text-muted">{{ $submission->transaction->cycle->cycle_name ?? '-' }}</td>
                    <td>{{ $submission->requirement->document_name ?? '-' }}</td>
                    <td>
                        @if($submission->is_submitted)
                            <span class="pill pill-success">Submitted</span>
                        @else
                            <span class="pill pill-danger">Missing</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ $submission->notes ?? '-' }}</td>
                    <td class="text-end">
                        <div class="row-actions">
                            <a href="{{ route('document-submissions.show', $submission) }}" class="row-action view" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('document-submissions.edit', $submission) }}" class="row-action edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <form action="{{ route('document-submissions.destroy', $submission) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Remove this submission?')">
                                @csrf @method('DELETE')
                                <button class="row-action delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="table-empty">
                        {{ $search !== '' || $selectedBarangay ? 'No document submissions match your filters.' : 'No document submissions recorded yet.' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $submissions->links() }}
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-submission-barangay-card]').forEach(function (card) {
        card.addEventListener('click', function () {
            card.classList.add('is-opening');
        });
    });
</script>
@endpush
