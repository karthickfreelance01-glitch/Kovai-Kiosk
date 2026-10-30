@extends('layouts.admin')
@section('title', 'Add Project')
@section('page-title', 'Create Project')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Add Completed Portfolio Project</h1>
        <p class="page-head-sub">Add manufacturing project images, client info, and location for showcase.</p>
    </div>
    <a href="{{ route('admin.projects.index') }}" class="btn-admin btn-admin-outline">
        ← Back to Projects
    </a>
</div>

<div style="max-width:850px">
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Project Details</h2>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="admin-form-group">
                    <label class="admin-form-label" for="proj-title">Project Title *</label>
                    <input type="text" id="proj-title" name="title" class="admin-form-control" value="{{ old('title') }}" required placeholder="e.g. CCD Coffee Kiosk – Phoenix Marketcity">
                    @error('title')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="proj-cat">Category</label>
                        <select id="proj-cat" name="category_id" class="admin-form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="proj-client">Client / Brand Name</label>
                        <input type="text" id="proj-client" name="client_name" class="admin-form-control" value="{{ old('client_name') }}" placeholder="e.g. Cafe Coffee Day">
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="proj-loc">Installation Location / City</label>
                        <input type="text" id="proj-loc" name="location" class="admin-form-control" value="{{ old('location') }}" placeholder="e.g. Chennai, Tamil Nadu">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="proj-date">Completion Date</label>
                        <input type="date" id="proj-date" name="completed_date" class="admin-form-control" value="{{ old('completed_date') }}">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="proj-desc">Project Overview</label>
                    <textarea id="proj-desc" name="description" class="admin-form-control" style="min-height:90px" placeholder="Scope of manufacturing work, materials used, custom accessories implemented...">{{ old('description') }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Project Installation Photos</label>
                    <div class="img-upload-area" onclick="document.getElementById('proj-images').click()">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--admin-gold)" stroke-width="1.5" style="margin:0 auto 8px;display:block"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <div style="font-weight:600;font-size:0.9rem">Select Project Photos</div>
                        <div style="font-size:0.75rem;color:var(--admin-muted);margin-top:2px">Select one or multiple images</div>
                    </div>
                    <input type="file" name="images[]" id="proj-images" multiple accept="image/*" style="display:none" onchange="previewProjImages(this)">
                    <div id="proj-previews" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(100px, 1fr));gap:10px;margin-top:12px"></div>
                </div>

                <div class="admin-form-row" style="margin-top:10px">
                    <div class="admin-form-group">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Feature on Homepage</span>
                        </label>
                    </div>

                    <div class="admin-form-group">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Published (Visible on site)</span>
                        </label>
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:24px">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        Save Project
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="btn-admin btn-admin-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewProjImages(input) {
    const grid = document.getElementById('proj-previews');
    grid.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const card = document.createElement('div');
                card.style = 'aspect-ratio:1;border-radius:6px;overflow:hidden;border:1px solid var(--admin-border);background:#000';
                card.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover">`;
                grid.appendChild(card);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection
