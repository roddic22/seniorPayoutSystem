@extends('layouts.app')
@section('topbar-title', 'Schedules')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow">Payouts</div>
        <h2 class="page-title">Payout schedules</h2>
        <div class="page-sub">Per-barangay disbursement schedules.</div>
    </div>
    <div class="page-actions">
        <a href="{{ route('payout-schedules.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New schedule
        </a>
    </div>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Cycle</th>
                <th>Barangay</th>
                <th>Date</th>
                <th>Time</th>
                <th>Venue</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td class="text-muted">{{ $schedule->cycle->cycle_name ?? '—' }}</td>
                    <td class="fw-semibold">{{ $schedule->barangay->name ?? '—' }}</td>
                    <td>{{ $schedule->scheduled_date }}</td>
                    <td>
                        {{ $schedule->time_start ?? '—' }}@if($schedule->time_end) — {{ $schedule->time_end }}@endif
                    </td>
                    <td>{{ $schedule->venue ?? '—' }}</td>
                    <td class="text-end">
                        <div class="row-actions">
                            <a href="{{ route('payout-schedules.show', $schedule) }}" class="row-action view" title="View"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('payout-schedules.edit', $schedule) }}" class="row-action edit" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('payout-schedules.destroy', $schedule) }}" method="POST"
                                onsubmit="return confirm('Delete this schedule?')" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="row-action delete" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="table-empty">No schedules created yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $schedules->links() }}
</div>
@endsection
