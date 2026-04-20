@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Barangays</h2>
    <a href="{{ route('barangays.create') }}" class="btn btn-primary">+ Add Barangay</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>City</th>
            <th>Seniors Count</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($barangays as $barangay)
        <tr>
            <td>{{ $barangay->id }}</td>
            <td>{{ $barangay->name }}</td>
            <td>{{ $barangay->city }}</td>
            <td>{{ $barangay->seniors()->count() }}</td>
            <td>
                <a href="{{ route('barangays.show', $barangay) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('barangays.edit', $barangay) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('barangays.destroy', $barangay) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this barangay?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $barangays->links() }}
@endsection