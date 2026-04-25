@extends('layouts.app')
@section('topbar-title', 'New requirement')
@section('content')

<div class="page-head">
    <div>
        <div class="page-eyebrow"><a href="{{ route('document-requirements.index') }}" class="text-muted text-decoration-none">Requirements</a> / New</div>
        <h2 class="page-title">Add document requirement</h2>
        <div class="page-sub">Define a document seniors must present.</div>
    </div>
</div>

<form action="{{ route('document-requirements.store') }}" method="POST">
    @csrf
    <div class="surface mb-3">
        <div class="form-section">
            <div class="form-section-title">Requirement details</div>
            <div class="form-grid">
                <div class="span-2">
                    <label class="form-label" for="cycle_id">Payout cycle</label>
                    <select name="cycle_id" id="cycle_id" class="form-select" required>
                        <option value="">Select cycle</option>
                        @foreach($cycles as $cycle)
                            <option value="{{ $cycle->id }}">{{ $cycle->cycle_name }}</option>
                        @endforeach
                    </select>
                    @error('cycle_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="span-2">
                    <label class="form-label" for="document_name">Document name</label>
                    <input type="text" name="document_name" id="document_name" class="form-control" placeholder="e.g. Valid ID, OSCA card" value="{{ old('document_name') }}" required>
                    @error('document_name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="span-2">
                    <label class="form-label" for="description">Description <span class="text-muted">(optional)</span></label>
                    <textarea name="description" id="description" class="form-control" rows="2" placeholder="Additional details about this requirement">{{ old('description') }}</textarea>
                </div>
                <div class="span-2">
                    <div class="form-check">
                        <input type="checkbox" name="is_mandatory" class="form-check-input" id="is_mandatory" checked>
                        <label class="form-check-label" for="is_mandatory">Mark as mandatory</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-footer">
            <a href="{{ route('document-requirements.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save requirement</button>
        </div>
    </div>
</form>
@endsection
