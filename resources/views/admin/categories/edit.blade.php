@extends('layouts.admin')
@section('title', 'Edit Category - ' . $category->name)
@section('page-title', 'Edit Category')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Edit Category: {{ $category->name }}</h1>
        <p class="page-head-sub">Update manufacturing category details, imagery, and SEO attributes.</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn-admin btn-admin-outline">
        ← Back to Categories
    </a>
</div>

<div style="max-width:850px">
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Modify Category</h2>
            <a href="{{ route('products.category', $category->slug) }}" target="_blank" class="btn-admin btn-admin-outline btn-admin-sm">
                View on Public Site ↗
            </a>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="category-name">Category Name *</label>
                        <input type="text" id="category-name" name="name" class="admin-form-control" value="{{ old('name', $category->name) }}" required>
                        @error('name')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="category-slug">URL Slug</label>
                        <input type="text" id="category-slug" name="slug" class="admin-form-control" value="{{ old('slug', $category->slug) }}">
                        @error('slug')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="category-desc">Description</label>
                    <textarea id="category-desc" name="description" class="admin-form-control">{{ old('description', $category->description) }}</textarea>
                    @error('description')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="category-sort">Sort Order</label>
                        <input type="number" id="category-sort" name="sort_order" class="admin-form-control" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="category-icon">Lucide / Feather Icon Name</label>
                        <input type="text" id="category-icon" name="icon" class="admin-form-control" value="{{ old('icon', $category->icon) }}" placeholder="monitor, shopping-cart, zap...">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Category Banner / Image</label>
                    @if($category->image)
                        <div style="margin-bottom:12px;display:flex;align-items:center;gap:16px">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" style="max-height:100px;border-radius:8px;border:1px solid var(--admin-border)">
                            <span style="font-size:0.75rem;color:var(--admin-muted)">Current image. Uploading a new file will replace it.</span>
                        </div>
                    @endif
                    <input type="file" name="image" id="category-image" class="admin-form-control" accept="image/*" onchange="previewImage(this, 'cat-preview')">
                    <div id="cat-preview" style="margin-top:12px;display:none">
                        <img src="" alt="Preview" style="max-height:160px;border-radius:8px;border:1px solid var(--admin-border)">
                    </div>
                    @error('image')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-row" style="margin-top:10px">
                    <div class="admin-form-group">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $category->is_featured) ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Feature this category on Homepage</span>
                        </label>
                    </div>

                    <div class="admin-form-group">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Active (Visible to public)</span>
                        </label>
                    </div>
                </div>

                <div style="border-top:1px solid var(--admin-border);padding-top:20px;margin-top:16px">
                    <h3 style="font-family:'Outfit',sans-serif;font-size:0.95rem;margin-bottom:14px;color:var(--admin-gold)">SEO Metadata (Optional)</h3>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="meta-title">SEO Title</label>
                        <input type="text" id="meta-title" name="meta_title" class="admin-form-control" value="{{ old('meta_title', $category->meta_title) }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="meta-desc">SEO Meta Description</label>
                        <textarea id="meta-desc" name="meta_description" class="admin-form-control" style="min-height:70px">{{ old('meta_description', $category->meta_description) }}</textarea>
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:24px">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        Update Category
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
