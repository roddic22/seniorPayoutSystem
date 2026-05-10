@extends('layouts.app')
@section('content')
<h2>EXPLAIN — Query Optimization Demo</h2>
<p class="text-muted">
    This shows MySQL's query execution plan for fetching claimed transactions.
    The <strong>key</strong> column confirms indexes are being used.
</p>
<div class="table-responsive">
    <table class="table table-bordered table-sm">
        <thead class="table-dark">
            <tr>
                <th>id</th><th>select_type</th><th>table</th>
                <th>type</th><th>possible_keys</th><th>key</th>
                <th>key_len</th><th>rows</th><th>Extra</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $row)
            <tr>
                <td>{{ $row->id }}</td>
                <td>{{ $row->select_type }}</td>
                <td>{{ $row->table }}</td>
                <td>
                    @if(in_array($row->type, ['ref','eq_ref','const']))
                        <span class="badge bg-success">{{ $row->type }}</span>
                    @else
                        <span class="badge bg-warning text-dark">{{ $row->type }}</span>
                    @endif
                </td>
                <td>{{ $row->possible_keys ?? '—' }}</td>
                <td><strong>{{ $row->key ?? 'NONE' }}</strong></td>
                <td>{{ $row->key_len ?? '—' }}</td>
                <td>{{ $row->rows }}</td>
                <td>{{ $row->Extra ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<a href="{{ route('dashboard') }}" class="btn btn-secondary mt-2">Back</a>
@endsection