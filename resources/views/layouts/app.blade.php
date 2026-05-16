<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Senior Payout System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --c-primary: #1e3a8a;
            --c-primary-600: #1d4ed8;
            --c-primary-50: #eff4ff;
            --c-ink: #0f172a;
            --c-ink-2: #334155;
            --c-muted: #64748b;
            --c-line: #e2e8f0;
            --c-line-soft: #eef2f7;
            --c-bg: #f5f6f8;
            --c-surface: #ffffff;
            --c-success: #047857;
            --c-success-bg: #ecfdf5;
            --c-warning: #b45309;
            --c-warning-bg: #fffbeb;
            --c-danger: #b91c1c;
            --c-danger-bg: #fef2f2;
            --c-info: #1d4ed8;
            --c-info-bg: #eff6ff;
            --radius-sm: .375rem;
            --radius: .5rem;
            --radius-lg: .75rem;
            --shadow-sm: 0 1px 2px rgba(15, 23, 42, .04);
            --shadow: 0 1px 3px rgba(15, 23, 42, .06), 0 1px 2px rgba(15, 23, 42, .04);
        }

        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--c-bg);
            color: var(--c-ink);
            font-size: .9rem;
            line-height: 1.5;
            animation: pageFadeIn .24s ease both;
        }

        a { color: var(--c-primary-600); transition: color .18s ease, background-color .18s ease, border-color .18s ease, box-shadow .18s ease, transform .18s ease; }

        @keyframes pageFadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes contentRise {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }

        /* ---------- Layout ---------- */
        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        .app-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 248px;
            background: var(--c-surface);
            color: var(--c-ink-2);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            border-right: 1px solid var(--c-line);
            transition: transform .24s ease, box-shadow .24s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .65rem;
            min-height: 60px;
            padding: 0 1.1rem;
            color: var(--c-ink);
            text-decoration: none;
            border-bottom: 1px solid var(--c-line);
        }

        .sidebar-brand-mark {
            display: inline-grid;
            place-items: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: var(--c-primary-600);
            color: #fff;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .04em;
        }

        .sidebar-brand-title {
            font-size: .82rem;
            font-weight: 600;
            color: var(--c-ink);
            line-height: 1.1;
        }

        .sidebar-brand-subtitle {
            color: var(--c-muted);
            font-size: .68rem;
            font-weight: 400;
            letter-spacing: .01em;
        }

        .sidebar-menu {
            padding: .75rem .55rem 1.5rem;
            overflow-y: auto;
            flex: 1;
        }

        .sidebar-heading {
            color: #94a3b8;
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: 1rem .8rem .35rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            color: #475569;
            text-decoration: none;
            border-radius: 6px;
            padding: .5rem .75rem;
            font-size: .825rem;
            font-weight: 500;
            margin-bottom: 1px;
            transition: background .12s ease, color .12s ease;
        }

        .sidebar-link i { font-size: 1rem; width: 18px; text-align: center; color: #94a3b8; }

        .sidebar-link:hover {
            background: #f1f5f9;
            color: var(--c-ink);
        }
        .sidebar-link:hover i { color: var(--c-ink-2); }

        .sidebar-link.active {
            background: var(--c-primary-50);
            color: var(--c-primary-600);
            box-shadow: inset 2px 0 0 var(--c-primary-600);
        }
        .sidebar-link.active i { color: var(--c-primary-600); }

        .app-main {
            flex: 1;
            min-width: 0;
            margin-left: 248px;
        }

        .app-topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--c-surface);
            border-bottom: 1px solid var(--c-line);
            padding: 0 1.5rem;
        }

        .topbar-title {
            margin: 0;
            font-size: .9rem;
            font-weight: 600;
            color: var(--c-ink);
        }

        .topbar-subtitle {
            color: var(--c-muted);
            font-size: .72rem;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .topbar-avatar {
            display: grid;
            place-items: center;
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: var(--c-primary-50);
            color: var(--c-primary);
            border: 1px solid var(--c-line);
            font-weight: 600;
            font-size: .75rem;
        }

        .app-shell {
            padding: 1.5rem 1.75rem 3rem;
            max-width: 1400px;
            animation: contentRise .28s ease both;
        }

        /* ---------- Page header ---------- */
        .page-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .page-eyebrow {
            color: var(--c-muted);
            font-size: .72rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: .25rem;
        }

        .page-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--c-ink);
            margin: 0;
            letter-spacing: -.01em;
        }

        .page-sub {
            color: var(--c-muted);
            font-size: .82rem;
            margin-top: .15rem;
        }

        .page-actions { display: flex; gap: .5rem; flex-wrap: wrap; }

        /* ---------- Typography ---------- */
        h1, h2, h3, h4, h5 {
            color: var(--c-ink);
            letter-spacing: -.01em;
        }
        h2 { font-size: 1.25rem; font-weight: 600; }
        h5 { font-size: .95rem; font-weight: 600; }

        .text-muted, .muted { color: var(--c-muted) !important; }

        /* ---------- Surface (card) ---------- */
        .surface, .card {
            background: var(--c-surface);
            border: 1px solid var(--c-line);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease, background-color .18s ease;
        }

        .surface-pad { padding: 1.25rem 1.5rem; }

        .surface-head {
            padding: .9rem 1.25rem;
            border-bottom: 1px solid var(--c-line-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .surface-head h5 { margin: 0; font-size: .9rem; font-weight: 600; }

        .surface-body { padding: 1.25rem; }

        /* ---------- Buttons ---------- */
        .btn {
            font-size: .82rem;
            font-weight: 500;
            border-radius: var(--radius);
            padding: .45rem .85rem;
            transition: background-color .18s ease, border-color .18s ease, color .18s ease, box-shadow .18s ease, transform .18s ease;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }
        .btn-sm { font-size: .75rem; padding: .3rem .6rem; }
        .btn-lg { font-size: .9rem; padding: .65rem 1.1rem; }

        .btn-primary {
            --bs-btn-bg: var(--c-primary-600);
            --bs-btn-border-color: var(--c-primary-600);
            --bs-btn-hover-bg: #1e40af;
            --bs-btn-hover-border-color: #1e40af;
            --bs-btn-active-bg: var(--c-primary);
            --bs-btn-active-border-color: var(--c-primary);
        }

        .btn-outline-secondary {
            --bs-btn-color: var(--c-ink-2);
            --bs-btn-border-color: var(--c-line);
            --bs-btn-hover-bg: var(--c-line-soft);
            --bs-btn-hover-border-color: var(--c-line);
            --bs-btn-hover-color: var(--c-ink);
            background: var(--c-surface);
        }

        .btn-secondary {
            --bs-btn-bg: var(--c-surface);
            --bs-btn-border-color: var(--c-line);
            --bs-btn-color: var(--c-ink-2);
            --bs-btn-hover-bg: var(--c-line-soft);
            --bs-btn-hover-border-color: var(--c-line);
            --bs-btn-hover-color: var(--c-ink);
        }

        .btn-success {
            --bs-btn-bg: var(--c-success);
            --bs-btn-border-color: var(--c-success);
            --bs-btn-hover-bg: #065f46;
            --bs-btn-hover-border-color: #065f46;
        }

        .btn-warning {
            --bs-btn-bg: var(--c-warning);
            --bs-btn-border-color: var(--c-warning);
            --bs-btn-color: #fff;
            --bs-btn-hover-bg: #92400e;
            --bs-btn-hover-border-color: #92400e;
            --bs-btn-hover-color: #fff;
        }

        .btn-danger {
            --bs-btn-bg: var(--c-danger);
            --bs-btn-border-color: var(--c-danger);
            --bs-btn-hover-bg: #991b1b;
            --bs-btn-hover-border-color: #991b1b;
        }

        .btn-info {
            --bs-btn-bg: #0e7490;
            --bs-btn-border-color: #0e7490;
            --bs-btn-color: #fff;
            --bs-btn-hover-bg: #155e75;
            --bs-btn-hover-border-color: #155e75;
            --bs-btn-hover-color: #fff;
        }

        .btn-ghost {
            background: transparent;
            color: var(--c-ink-2);
            border: 1px solid transparent;
        }
        .btn-ghost:hover { background: var(--c-line-soft); color: var(--c-ink); }

        /* Row-action button group */
        .row-actions {
            display: inline-flex;
            gap: .25rem;
            align-items: center;
        }
        .row-action {
            display: inline-grid;
            place-items: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            color: var(--c-ink-2);
            background: transparent;
            border: 1px solid transparent;
            text-decoration: none;
            font-size: .85rem;
            transition: background-color .18s ease, border-color .18s ease, color .18s ease, transform .18s ease;
        }
        .row-action:hover { transform: translateY(-1px); }
        .row-action:hover { background: var(--c-line-soft); color: var(--c-ink); }
        .row-action.delete:hover { background: var(--c-danger-bg); color: var(--c-danger); }
        .row-action.edit:hover { background: var(--c-warning-bg); color: var(--c-warning); }
        .row-action.view:hover { background: var(--c-info-bg); color: var(--c-info); }

        /* ---------- Tables ---------- */
        .table-wrap {
            background: var(--c-surface);
            border: 1px solid var(--c-line);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            animation: contentRise .28s ease both;
        }

        .table {
            margin: 0;
            border-color: var(--c-line);
            vertical-align: middle;
            font-size: .82rem;
        }

        .table > :not(caption) > * > * {
            padding: .7rem .9rem;
            border-bottom-width: 1px;
            border-color: var(--c-line-soft);
        }

        .table thead th {
            background: #f8fafc;
            color: var(--c-muted);
            font-weight: 600;
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            border-bottom: 1px solid var(--c-line);
            white-space: nowrap;
        }

        .table tbody tr { transition: background-color .18s ease; }
        .table tbody tr:hover { background: #fafbfc; }
        .table tbody tr:last-child td { border-bottom: 0; }

        .table-empty {
            text-align: center;
            color: var(--c-muted);
            padding: 2.5rem 1rem !important;
            font-style: italic;
            font-size: .85rem;
        }

        /* Override Bootstrap's table-dark / table-bordered / table-striped to keep new look */
        .table-bordered > :not(caption) > * { border-width: 0; }
        .table-striped > tbody > tr:nth-of-type(odd) > * { background: transparent; }
        .table-dark { --bs-table-bg: #f8fafc; --bs-table-color: var(--c-muted); }
        .table-dark th { background: #f8fafc !important; color: var(--c-muted) !important; }

        /* ---------- Pills / badges ---------- */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            padding: .15rem .55rem;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 600;
            line-height: 1.4;
            letter-spacing: .01em;
            border: 1px solid transparent;
        }
        .pill::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background: currentColor;
            opacity: .9;
        }
        .pill-success { background: var(--c-success-bg); color: var(--c-success); border-color: #a7f3d0; }
        .pill-warning { background: var(--c-warning-bg); color: var(--c-warning); border-color: #fde68a; }
        .pill-danger  { background: var(--c-danger-bg);  color: var(--c-danger);  border-color: #fecaca; }
        .pill-info    { background: var(--c-info-bg);    color: var(--c-info);    border-color: #bfdbfe; }
        .pill-muted   { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
        .pill-dark    { background: #0f172a; color: #fff; border-color: #0f172a; }
        .pill-dark::before { background: #fff; }

        /* Bootstrap badge fallback */
        .badge {
            font-weight: 600;
            font-size: .7rem;
            padding: .3rem .55rem;
            border-radius: 999px;
        }
        .bg-success { background: var(--c-success) !important; }
        .bg-warning { background: var(--c-warning) !important; color: #fff !important; }
        .bg-danger  { background: var(--c-danger)  !important; }
        .bg-info    { background: #0e7490 !important; color: #fff !important; }
        .bg-secondary { background: #e2e8f0 !important; color: #334155 !important; }
        .bg-dark      { background: #0f172a !important; }
        .text-primary { color: var(--c-primary-600) !important; }

        /* ---------- Forms ---------- */
        .form-label, .form-check-label {
            font-size: .78rem;
            font-weight: 500;
            color: var(--c-ink-2);
            margin-bottom: .35rem;
        }

        .form-control, .form-select {
            border-radius: var(--radius);
            border: 1px solid var(--c-line);
            font-size: .85rem;
            padding: .5rem .7rem;
            background: var(--c-surface);
            color: var(--c-ink);
            box-shadow: none;
            transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
        }

        .form-control::placeholder { color: #94a3b8; }

        .form-control:focus, .form-select:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, .12);
        }

        .form-control-lg { font-size: .9rem; padding: .6rem .8rem; }

        textarea.form-control { min-height: 5.5rem; }

        .form-check-input { border-color: #cbd5e1; }
        .form-check-input:checked { background-color: var(--c-primary-600); border-color: var(--c-primary-600); }

        .form-hint { color: var(--c-muted); font-size: .72rem; margin-top: .25rem; }
        .form-error { color: var(--c-danger); font-size: .72rem; margin-top: .25rem; }

        /* Form section */
        .form-section { padding: 1.25rem 1.5rem; }
        .form-section + .form-section { border-top: 1px solid var(--c-line-soft); }
        .form-section-title {
            font-size: .82rem;
            font-weight: 600;
            color: var(--c-ink);
            margin-bottom: .25rem;
        }
        .form-section-sub { color: var(--c-muted); font-size: .76rem; margin-bottom: 1rem; }

        .form-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        .form-grid .span-2 { grid-column: 1 / -1; }
        @media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }

        .form-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--c-line-soft);
            display: flex;
            justify-content: flex-end;
            gap: .5rem;
            background: #fafbfc;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        }

        /* ---------- KPI cards ---------- */
        .kpi {
            background: var(--c-surface);
            border: 1px solid var(--c-line);
            border-radius: var(--radius-lg);
            padding: 1.1rem 1.25rem;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
        }
        .kpi-label {
            color: var(--c-muted);
            font-size: .72rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: .07em;
            margin-bottom: .35rem;
        }
        .kpi-value {
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--c-ink);
            letter-spacing: -.02em;
            line-height: 1.1;
        }
        .kpi-foot { color: var(--c-muted); font-size: .75rem; margin-top: .35rem; }
        .kpi-icon {
            position: absolute;
            top: 1rem; right: 1rem;
            display: grid;
            place-items: center;
            width: 32px; height: 32px;
            border-radius: 8px;
            background: var(--c-line-soft);
            color: var(--c-ink-2);
            font-size: 1rem;
        }
        .kpi.kpi-success .kpi-icon { background: var(--c-success-bg); color: var(--c-success); }
        .kpi.kpi-warning .kpi-icon { background: var(--c-warning-bg); color: var(--c-warning); }
        .kpi.kpi-danger  .kpi-icon { background: var(--c-danger-bg);  color: var(--c-danger); }
        .kpi.kpi-info    .kpi-icon { background: var(--c-info-bg);    color: var(--c-info); }

        /* ---------- Definition list ---------- */
        .deflist {
            display: grid;
            grid-template-columns: minmax(140px, 200px) 1fr;
            row-gap: .15rem;
        }
        .deflist dt {
            color: var(--c-muted);
            font-size: .76rem;
            font-weight: 500;
            padding: .55rem 0;
            border-bottom: 1px solid var(--c-line-soft);
        }
        .deflist dd {
            color: var(--c-ink);
            font-size: .85rem;
            margin: 0;
            padding: .55rem 0;
            border-bottom: 1px solid var(--c-line-soft);
        }
        .deflist dt:last-of-type, .deflist dd:last-of-type { border-bottom: 0; }
        @media (max-width: 540px) {
            .deflist { grid-template-columns: 1fr; }
            .deflist dt { padding-bottom: 0; border-bottom: 0; }
            .deflist dd { padding-top: .15rem; }
        }

        /* ---------- Alerts ---------- */
        .alert {
            border-radius: var(--radius);
            border-width: 1px;
            font-size: .82rem;
            padding: .65rem .85rem;
        }
        .alert-success { background: var(--c-success-bg); color: var(--c-success); border-color: #a7f3d0; }
        .alert-danger  { background: var(--c-danger-bg);  color: var(--c-danger);  border-color: #fecaca; }
        .alert-warning { background: var(--c-warning-bg); color: var(--c-warning); border-color: #fde68a; }

        /* ---------- Pagination ---------- */
        .pagination { font-size: .82rem; }
        .pagination svg {
            width: 1rem;
            height: 1rem;
        }
        .page-link {
            color: var(--c-ink-2);
            border-color: var(--c-line);
            padding: .35rem .65rem;
        }
        .page-item.active .page-link {
            background: var(--c-primary-600);
            border-color: var(--c-primary-600);
        }

        /* ---------- Empty state ---------- */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--c-muted);
        }
        .empty-state i { font-size: 2rem; color: #94a3b8; margin-bottom: .5rem; }

        /* ---------- Mobile sidebar ---------- */
        .sidebar-toggle { display: none; }

        @media (max-width: 991.98px) {
            .app-sidebar {
                transform: translateX(-100%);
                transition: transform .2s ease;
                box-shadow: 4px 0 16px rgba(15, 23, 42, .15);
            }
            .app-sidebar.show { transform: translateX(0); }
            .app-main { margin-left: 0; }
            .sidebar-toggle { display: inline-flex; }
            .app-shell { padding: 1rem; }
        }

        /* ---------- Print ---------- */
        @media print {
            .app-sidebar, .app-topbar, .page-actions, .no-print { display: none !important; }
            .app-main { margin-left: 0 !important; }
            .app-shell { padding: 0 !important; }
            .surface, .card, .table-wrap { box-shadow: none !important; border-color: #ddd !important; }
        }
    </style>
    @stack('head')
</head>
<body>

<div class="app-layout">
    <aside class="app-sidebar" id="appSidebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="sidebar-brand-mark">SPS</span>
            <span>
                <span class="sidebar-brand-title d-block">Senior Payout</span>
                <span class="sidebar-brand-subtitle d-block">Management portal</span>
            </span>
        </a>

       <nav class="sidebar-menu">
    <div class="sidebar-heading">Overview</div>
    <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
        href="{{ route('dashboard') }}">
        <i class="bi bi-grid-1x2"></i> Dashboard
    </a>

    <div class="sidebar-heading">Records</div>
    <a class="sidebar-link {{ request()->routeIs('seniors.*') ? 'active' : '' }}"
        href="{{ route('seniors.index') }}">
        <i class="bi bi-people"></i> Seniors
    </a>
    <a class="sidebar-link {{ request()->routeIs('barangays.*') ? 'active' : '' }}"
        href="{{ route('barangays.index') }}">
        <i class="bi bi-geo-alt"></i> Barangays
    </a>

    <div class="sidebar-heading">Payouts</div>
    <a class="sidebar-link {{ request()->routeIs('payout-cycles.*') ? 'active' : '' }}"
        href="{{ route('payout-cycles.index') }}">
        <i class="bi bi-arrow-repeat"></i> Cycles
    </a>
    <a class="sidebar-link {{ request()->routeIs('payout-schedules.*') ? 'active' : '' }}"
        href="{{ route('payout-schedules.index') }}">
        <i class="bi bi-calendar3"></i> Schedules
    </a>
    <a class="sidebar-link {{ request()->routeIs('payout-transactions.*') ? 'active' : '' }}"
        href="{{ route('payout-transactions.index') }}">
        <i class="bi bi-receipt"></i> Transactions
    </a>

    <div class="sidebar-heading">Operations</div>
    <a class="sidebar-link {{ request()->routeIs('document-requirements.*') ? 'active' : '' }}"
        href="{{ route('document-requirements.index') }}">
        <i class="bi bi-file-earmark-check"></i> Requirements
    </a>

    @if(auth()->user()->role === 'admin')
    <a class="sidebar-link {{ request()->routeIs('counters.*') ? 'active' : '' }}"
        href="{{ route('counters.index') }}">
        <i class="bi bi-window-stack"></i> Counters
    </a>
    <a class="sidebar-link {{ request()->routeIs('staff-assignments.*') ? 'active' : '' }}"
        href="{{ route('staff-assignments.index') }}">
        <i class="bi bi-person-badge"></i> Staff Assignments
    </a>
    <a class="sidebar-link {{ request()->routeIs('staff.*') ? 'active' : '' }}"
        href="{{ route('staff.index') }}">
        <i class="bi bi-person-lines-fill"></i> Staff
    </a>
    @endif

    <div class="sidebar-heading">Insights</div>
    <a class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
        href="{{ route('reports.index') }}">
        <i class="bi bi-bar-chart"></i> Reports
    </a>

    @if(auth()->user()->role === 'admin')
    <a class="sidebar-link {{ request()->routeIs('explain.demo') ? 'active' : '' }}"
        href="{{ route('explain.demo') }}">
        <i class="bi bi-lightning"></i> EXPLAIN Demo
    </a>
    @endif
</nav>
    </aside>

    <div class="app-main">
        <header class="app-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary sidebar-toggle" type="button" id="sidebarToggle" aria-label="Toggle navigation">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h1 class="topbar-title">@yield('topbar-title', 'Senior Payout System')</h1>
                    <div class="topbar-subtitle">@yield('topbar-sub', 'Administrative console')</div>
                </div>
            </div>

            <div class="topbar-user">
                <div class="topbar-avatar" title="{{ auth()->user()->name ?? '' }}">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-box-arrow-right me-1"></i> Sign out
                    </button>
                </form>
            </div>
        </header>

        <main class="app-shell">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function () {
        document.getElementById('appSidebar')?.classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>
