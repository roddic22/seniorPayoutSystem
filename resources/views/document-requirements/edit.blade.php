@extends('layouts.app')
@section('content')
<h2>Edit Document Requirement</h2>
<div class="card p-4 mt-3">
    <form action="{{ route('document-requirements.update', $documentRequirement) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Payout Cycle</label>
            <select name="cycle_id" class="form-control" required>
                <option value="">-- Select Cycle --</option>
                @foreach($cycles as $cycle)
                    <option value="{{ $cycle->id }}"
                        {{ $documentRequirement->cycle_id == $cycle->id ? 'selected' : '' }}>
                        {{ $cycle->cycle_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Document Name</label>
            <input type="text" name="document_name" class="form-control"
                value="{{ $documentRequirement->document_name }}" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="2">{{ $documentRequirement->description }}</textarea>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_mandatory" class="form-check-input" id="is_mandatory"
                {{ $documentRequirement->is_mandatory ? 'checked' : '' }}>
            <label class="form-check-label" for="is_mandatory">Mandatory</label>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('document-requirements.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection