@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Senior Citizens</h2>
    <a href="{{ route('seniors.create') }}" class="btn btn-primary">+ Add Senior</a>
</div>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>OSCA ID</th><th>Name</th><th>Age</th>
            <th>Barangay</th><th>Status</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($seniors as $senior)
        <tr>
            <td>{{ $senior->osca_id }}</td>
            <td>{{ $senior->name }}</td>
            <td>{{ $senior->age }}</td>
            <td>{{ $senior->barangay->name ?? 'N/A' }}</td>
            <td>{{ $senior->status }}</td>
            <td>
                <a href="{{ route('seniors.show', $senior) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('seniors.edit', $senior) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('seniors.destroy', $senior) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this record?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $seniors->links() }}
@endsection