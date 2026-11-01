@extends('layouts.admin')
@section('title', 'Edit Project - ' . $project->title)
@section('page-title', 'Edit Project')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Edit Project: {{ $project->title }}</h1>
        <p class="page-head-sub">Update project photography, client details, and showcase description.</p>
    </div>
    <a href="{{ route('admin.projects.index') }}" class="btn-admin btn-admin-outline">
        ← Back to Projects
    </a>
</div>

<div style="max-width:850px">
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Modify Project</h2>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="admin-form-group">
                    <label class="admin-form-label" for="proj-title">Project Title *</label>
                    <input type="text" id="proj-title" name="title" class="admin-form-control" value="{{ old('title', $project->title) }}" required>
                    @error('title')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="proj-cat">Category</label>
                        <select id="proj-cat" name="category_id" class="admin-form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $project->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="proj-client">Client / Brand Name</label>
                        <input type="text" id="proj-client" name="client_name" class="admin-form-control" value="{{ old('client_name', $project->client_name) }}">
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="proj-loc">Installation Location / City</label>
                        <input type="text" id="proj-loc" name="location" class="admin-form-control" value="{{ old('location', $project->location) }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="proj-date">Completion Date</label>
                        <input type="date" id="proj-date" name="completed_date" class="admin-form-control" value="{{ old('completed_date', $project->completed_date ? \Carbon\Carbon::parse($project->completed_date)->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="proj-desc">Project Overview</label>
                    <textarea id="proj-desc" name="description" class="admin-form-control" style="min-height:90px">{{ old('description', $project->description) }}</textarea>
                </div>

                <!-- Existing Images -->
                @if($project->images->count() > 0)
                <div style="margin-bottom:24px">
                    <label class="admin-form-label">Current Photos ({{ $project->images->count() }})</label>
                    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(140px, 1fr));gap:14px">
                        @foreach($project->images as $pImg)
                        @php $isPrimary = ($pImg->image_path === $project->primary_image); @endphp
                        <div style="position:relative;border-radius:8px;overflow:hidden;border:2px solid {{ $isPrimary ? 'var(--admin-gold)' : 'var(--admin-border)' }};background:var(--admin-bg)">
                            <div style="aspect-ratio:1;overflow:hidden">
                                <img src="{{ $pImg->url }}" alt="Photo" style="width:100%;height:100%;object-fit:cover">
                            </div>
                            @if($isPrimary)
                                <div style="position:absolute;top:6px;left:6px;background:var(--admin-gold);color:#000;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:4px;box-shadow:0 2px 4px rgba(0,0,0,0.3)">
                                    Primary
                                </div>
                            @endif
                            <div style="padding:6px 8px;background:var(--admin-sidebar);display:flex;justify-content:space-between;align-items:center;gap:4px">
                                @if(!$isPrimary)
                                    <button type="button" onclick="document.getElementById('set-primary-form-{{ $pImg->id }}').submit()" class="btn-admin btn-admin-outline btn-admin-sm" style="font-size:0.7rem;padding:3px 6px" title="Set as primary photo">
                                        Make Main
                                    </button>
                                @else
                                    <span style="font-size:0.7rem;color:var(--admin-gold);font-weight:600">Main Photo</span>
                                @endif

                                <button type="button" onclick="if(confirm('Delete this photo?')) document.getElementById('delete-img-form-{{ $pImg->id }}').submit()" class="btn-admin btn-admin-danger btn-admin-sm" style="padding:3px 8px;font-size:0.75rem" title="Delete photo">
                                    &times;
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="admin-form-group">
                    <label class="admin-form-label">Add More Photos</label>
                    <div class="img-upload-area" onclick="document.getElementById('proj-images').click()">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--admin-gold)" stroke-width="1.5" style="margin:0 auto 6px;display:block"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        <div style="font-weight:600;font-size:0.88rem">Click to add photos</div>
                    </div>
                    <input type="file" name="images[]" id="proj-images" multiple accept="image/*" style="display:none" onchange="previewProjImages(this)">
                    <div id="proj-previews" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(100px, 1fr));gap:10px;margin-top:12px"></div>
                </div>

                <div class="admin-form-row" style="margin-top:10px">
                    <div class="admin-form-group">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Feature on Homepage</span>
                        </label>
                    </div>

                    <div class="admin-form-group">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $project->is_active) ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Published (Visible on site)</span>
                        </label>
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:24px">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        Update Project
                    </button>
                    <a href="{{ route('admin.projects.index') }}" class="btn-admin btn-admin-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($project->images as $pImg)
    <form id="set-primary-form-{{ $pImg->id }}" action="{{ route('admin.projects.images.set-primary', $pImg->id) }}" method="POST" style="display:none">
        @csrf
    </form>
    <form id="delete-img-form-{{ $pImg->id }}" action="{{ route('admin.projects.images.delete', $pImg->id) }}" method="POST" style="display:none">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<script>
function previewProjImages(input) {
    const grid = document.getElementById('proj-previews');
    grid.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const card = document.createElement('div');
                card.style = 'aspect-ratio:1;border-radius:6px;overflow:hidden;border:1px solid var(--admin-border);background:var(--admin-bg)';
                card.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover">`;
                grid.appendChild(card);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection
