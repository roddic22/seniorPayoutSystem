@extends('layouts.app')
@section('topbar-title', 'Edit requirement')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('document-requirements.index') }}" class="text-muted text-decoration-none">Requirements</a> / Edit</div>
        <h2 class="page-title">Edit document requirement</h2>
    </div>
</div>

<form action="{{ route('document-requirements.update', $documentRequirement) }}" method="POST">
    @csrf @method('PUT')
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Requirement details</div>
            <div class="form-grid">
                <div class="span-2">
                    <label class="form-label" for="cycle_id">Payout cycle</label>
                    <select name="cycle_id" id="cycle_id" class="form-select" required>
                        <option value="">Select cycle</option>
                        @foreach($cycles as $cycle)
                            <option value="{{ $cycle->id }}" {{ $documentRequirement->cycle_id == $cycle->id ? 'selected' : '' }}>
                                {{ $cycle->cycle_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="span-2">
                    <label class="form-label" for="document_name">Document name</label>
                    <input type="text" name="document_name" id="document_name" class="form-control" value="{{ old('document_name', $documentRequirement->document_name) }}" required>
                </div>
                <div class="span-2">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="2">{{ old('description', $documentRequirement->description) }}</textarea>
                </div>
                <div class="span-2">
                    <div class="form-check">
                        <input type="checkbox" name="is_mandatory" class="form-check-input" id="is_mandatory" {{ $documentRequirement->is_mandatory ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_mandatory">Mark as mandatory</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('document-requirements.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>
@endsection
