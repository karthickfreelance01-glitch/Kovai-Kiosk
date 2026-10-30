@extends('layouts.admin')
@section('title', 'Add Category')
@section('page-title', 'Create Category')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Add New Category</h1>
        <p class="page-head-sub">Create a new manufacturing product category for your website showcase.</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn-admin btn-admin-outline">
        ← Back to Categories
    </a>
</div>

<div style="max-width:850px">
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Category Details</h2>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="category-name">Category Name *</label>
                        <input type="text" id="category-name" name="name" class="admin-form-control" value="{{ old('name') }}" required placeholder="e.g. Smart Kiosks">
                        @error('name')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="category-slug">URL Slug (Optional)</label>
                        <input type="text" id="category-slug" name="slug" class="admin-form-control" value="{{ old('slug') }}" placeholder="smart-kiosks (auto-generated if empty)">
                        @error('slug')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="category-desc">Description</label>
                    <textarea id="category-desc" name="description" class="admin-form-control" placeholder="Brief description of this kiosk manufacturing category...">{{ old('description') }}</textarea>
                    @error('description')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="category-sort">Sort Order</label>
                        <input type="number" id="category-sort" name="sort_order" class="admin-form-control" value="{{ old('sort_order', 1) }}" min="0">
                        <small style="color:var(--admin-muted);font-size:0.75rem">Lower numbers appear first in navigation.</small>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="category-icon">Lucide / Feather Icon Name</label>
                        <input type="text" id="category-icon" name="icon" class="admin-form-control" value="{{ old('icon', 'monitor') }}" placeholder="monitor, shopping-cart, zap...">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Category Banner / Showcase Image</label>
                    <input type="file" name="image" id="category-image" class="admin-form-control" accept="image/*" onchange="previewImage(this, 'cat-preview')">
                    <div id="cat-preview" style="margin-top:12px;display:none">
                        <img src="" alt="Preview" style="max-height:160px;border-radius:8px;border:1px solid var(--admin-border)">
                    </div>
                    @error('image')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-row" style="margin-top:10px">
                    <div class="admin-form-group">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Feature this category on Homepage</span>
                        </label>
                    </div>

                    <div class="admin-form-group">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Active (Visible to public)</span>
                        </label>
                    </div>
                </div>

                <div style="border-top:1px solid var(--admin-border);padding-top:20px;margin-top:16px">
                    <h3 style="font-family:'Outfit',sans-serif;font-size:0.95rem;margin-bottom:14px;color:var(--admin-gold)">SEO Metadata (Optional)</h3>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="meta-title">SEO Title</label>
                        <input type="text" id="meta-title" name="meta_title" class="admin-form-control" value="{{ old('meta_title') }}" placeholder="Custom title tag for search engines">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="meta-desc">SEO Meta Description</label>
                        <textarea id="meta-desc" name="meta_description" class="admin-form-control" style="min-height:70px" placeholder="Brief search snippet description...">{{ old('meta_description') }}</textarea>
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:24px">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        Save Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn-admin btn-admin-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
