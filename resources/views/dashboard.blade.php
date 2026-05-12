@extends('layouts.app')
@section('topbar-title', 'Dashboard')
@section('topbar-sub', 'System overview and analytics')

@section('content')

{{-- KPI Row --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="kpi">
            <div class="kpi-label">Registered Seniors</div>
            <div class="kpi-value">{{ $totalSeniors }}</div>
            <div class="kpi-icon"><i class="bi bi-people"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="kpi kpi-success">
            <div class="kpi-label">Total Claimed</div>
            <div class="kpi-value text-success">{{ $totalClaimed }}</div>
            <div class="kpi-icon"><i class="bi bi-check-circle"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="kpi kpi-warning">
            <div class="kpi-label">Unclaimed</div>
            <div class="kpi-value text-warning">{{ $totalUnclaimed }}</div>
            <div class="kpi-icon"><i class="bi bi-hourglass-split"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="kpi kpi-info">
            <div class="kpi-label">Amount Released</div>
            <div class="kpi-value" style="font-size:1.2rem">₱{{ number_format($totalAmount, 0) }}</div>
            <div class="kpi-icon"><i class="bi bi-cash-stack"></i></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="kpi">
            <div class="kpi-label">Payout Cycles</div>
            <div class="kpi-value">{{ $totalCycles }}</div>
            <div class="kpi-icon"><i class="bi bi-arrow-repeat"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="kpi">
            <div class="kpi-label">Barangays</div>
            <div class="kpi-value">{{ $totalBarangays }}</div>
            <div class="kpi-icon"><i class="bi bi-geo-alt"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="kpi">
            <div class="kpi-label">Counters</div>
            <div class="kpi-value">{{ $totalCounters }}</div>
            <div class="kpi-icon"><i class="bi bi-window-stack"></i></div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="kpi kpi-danger">
            <div class="kpi-label">Cancelled</div>
            <div class="kpi-value text-danger">{{ $totalCancelled }}</div>
            <div class="kpi-icon"><i class="bi bi-x-circle"></i></div>
        </div>
    </div>
</div>

{{-- Monthly Breakdown + Active Cycles --}}
<div class="row g-3 mb-4">

    {{-- By Month --}}
    <div class="col-md-8">
        <div class="surface">
            <div class="surface-head">
                <h5><i class="bi bi-calendar3 me-2"></i>Transactions by Month</h5>
                <span class="text-muted" style="font-size:.75rem">Last 6 months</span>
            </div>
            <div class="surface-body p-0">
                @if($byMonth->isEmpty())
                    <div class="empty-state">
                        <i class="bi bi-calendar-x d-block"></i>
                        No transaction data yet.
                    </div>
                @else
                <div class="table-wrap" style="border-radius:0;border:0;box-shadow:none">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Total</th>
                                <th>Claimed</th>
                                <th>Unclaimed</th>
                                <th>Amount Released</th>
                                <th>Claim Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($byMonth as $row)
                            @php
                                $rate = $row->total > 0 ? round(($row->claimed / $row->total) * 100) : 0;
                            @endphp
                            <tr>
                                <td><strong>{{ $row->month }}</strong></td>
                                <td>{{ $row->total }}</td>
                                <td><span class="pill pill-success">{{ $row->claimed }}</span></td>
                                <td><span class="pill pill-warning">{{ $row->unclaimed }}</span></td>
                                <td>₱{{ number_format($row->amount_released, 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="flex:1;height:6px;background:#e2e8f0;border-radius:99px;overflow:hidden">
                                            <div style="width:{{ $rate }}%;height:100%;background:#047857;border-radius:99px"></div>
                                        </div>
                                        <span style="font-size:.72rem;color:#64748b;min-width:32px">{{ $rate }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Active Cycles + Upcoming --}}
    <div class="col-md-4">
        <div class="surface mb-3">
            <div class="surface-head">
                <h5><i class="bi bi-arrow-repeat me-2"></i>Active Cycles</h5>
            </div>
            <div class="surface-body">
                @forelse($activeCycles as $cycle)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span style="font-size:.82rem">{{ $cycle->cycle_name }}</span>
                    <a href="{{ route('payout-cycles.show', $cycle) }}" class="btn btn-sm btn-outline-secondary">View</a>
                </div>
                @empty
                <p class="text-muted mb-0" style="font-size:.82rem">No active cycles.</p>
                @endforelse
            </div>
        </div>

        <div class="surface">
            <div class="surface-head">
                <h5><i class="bi bi-calendar-event me-2"></i>Upcoming Schedules</h5>
            </div>
            <div class="surface-body p-0">
                @forelse($upcomingSchedules as $schedule)
                <div style="padding:.65rem 1.1rem;border-bottom:1px solid #eef2f7">
                    <div style="font-size:.82rem;font-weight:500">{{ $schedule->barangay->name ?? 'No Barangay' }}</div>
                    <div style="font-size:.72rem;color:#64748b">
                        {{ $schedule->scheduled_date }}
                        @if($schedule->time_start) · {{ $schedule->time_start }} @endif
                    </div>
                </div>
                @empty
                <div class="empty-state" style="padding:1.5rem">No upcoming schedules.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- By Barangay --}}
<div class="surface">
    <div class="surface-head">
        <h5><i class="bi bi-geo-alt me-2"></i>Payout Summary by Barangay</h5>
        <a href="{{ route('barangays.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <div class="surface-body p-0">
        @if($byBarangay->isEmpty())
            <div class="empty-state"><i class="bi bi-geo d-block"></i>No data yet.</div>
        @else
        <div class="table-wrap" style="border-radius:0;border:0;box-shadow:none">
            <table class="table">
                <thead>
                    <tr>
                        <th>Barangay</th>
                        <th>Total Seniors</th>
                        <th>Claimed</th>
                        <th>Unclaimed</th>
                        <th>Amount Released</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($byBarangay as $row)
                    @php
                        $rate = $row->total > 0 ? round(($row->claimed / $row->total) * 100) : 0;
                    @endphp
                    <tr>
                        <td><strong>{{ $row->name }}</strong></td>
                        <td>{{ $row->total ?: '—' }}</td>
                        <td><span class="pill pill-success">{{ $row->claimed }}</span></td>
                        <td><span class="pill pill-warning">{{ $row->unclaimed }}</span></td>
                        <td>₱{{ number_format($row->amount_released, 2) }}</td>
                        <td style="min-width:120px">
                            <div class="d-flex align-items-center gap-2">
                                <div style="flex:1;height:6px;background:#e2e8f0;border-radius:99px;overflow:hidden">
                                    <div style="width:{{ $rate }}%;height:100%;background:#1d4ed8;border-radius:99px"></div>
                                </div>
                                <span style="font-size:.72rem;color:#64748b;min-width:32px">{{ $rate }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@endsection