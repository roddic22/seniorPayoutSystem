@extends('layouts.app')
@section('content')
<h2>Barangay: {{ $barangay->name }}</h2>
<div class="card p-4 mb-4">
    <p><strong>City:</strong> {{ $barangay->city }}</p>
    <p><strong>Total Seniors:</strong> {{ $barangay->seniors()->count() }}</p>
</div>

<h5>Seniors in this Barangay</h5>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
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
            <td>{{ $senior->osca_id }}</td>
            <td>{{ $senior->name }}</td>
            <td>{{ $senior->age }}</td>
            <td>{{ $senior->status }}</td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center">No seniors in this barangay yet.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $seniors->links() }}
<a href="{{ route('barangays.index') }}" class="btn btn-secondary mt-2">Back</a>
@endsection