<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Payout System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Senior Payout System</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('seniors.index') }}">Seniors</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('barangays.index') }}">Barangays</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('payout-cycles.index') }}">Payout Cycles</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('payout-schedules.index') }}">Schedules</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('payout-transactions.index') }}">Transactions</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('counters.index') }}">Counters</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">Reports</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>