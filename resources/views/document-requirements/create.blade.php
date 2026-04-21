@extends('layouts.app')
@section('content')
<h2>Add Document Requirement</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('document-requirements.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Payout Cycle</label>
            <select name="cycle_id" class="form-control" required>
                <option value="">-- Select Cycle --</option>
                @foreach($cycles as $cycle)
                    <option value="{{ $cycle->id }}">{{ $cycle->cycle_name }}</option>
                @endforeach
            </select>
            @error('cycle_id')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Document Name</label>
            <input type="text" name="document_name" class="form-control"
                placeholder="e.g. Valid ID, OSCA Card" required>
            @error('document_name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label>Description <span class="text-muted">(optional)</span></label>
            <textarea name="description" class="form-control" rows="2"
                placeholder="Additional details about this requirement"></textarea>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_mandatory" class="form-check-input" id="is_mandatory" checked>
            <label class="form-check-label" for="is_mandatory">Mandatory</label>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('document-requirements.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection