@extends('layouts.app')
@section('topbar-title', 'Payout cycles')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Payouts</div>
        <h2 class="page-title">Payout cycles</h2>
        <div class="page-sub">Disbursement periods configured for the program.</div>
    </div>
    <div class="page-actions">
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('payout-cycles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New cycle
        </a>
        @endif
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Cycle name</th>
                <th>Period start</th>
                <th>Period end</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cycles as $cycle)
                <tr>
                    <td class="fw-semibold">{{ $cycle->cycle_name }}</td>
                    <td>{{ $cycle->period_start }}</td>
                    <td>{{ $cycle->period_end }}</td>
                    <td>
                        @if($cycle->status === 'active')
                            <span class="pill pill-success">Active</span>
                        @elseif($cycle->status === 'draft')
                            <span class="pill pill-muted">Draft</span>
                        @else
                            <span class="pill pill-dark">Completed</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="row-actions">
                            <a href="{{ route('payout-cycles.show', $cycle) }}"
                                class="row-action view" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('payout-cycles.edit', $cycle) }}"
                                class="row-action edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('payout-cycles.destroy', $cycle) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this cycle?')"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="row-action delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="table-empty">No payout cycles configured yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $cycles->links() }}
</div>
@endsection
