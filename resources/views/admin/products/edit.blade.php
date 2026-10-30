@extends('layouts.admin')
@section('title', 'Edit Product - ' . $product->name)
@section('page-title', 'Edit Product')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Edit Product: {{ $product->name }}</h1>
        <p class="page-head-sub">Update manufacturing specifications, imagery gallery, and catalogue settings.</p>
    </div>
    <div style="display:flex;gap:12px">
        @if($product->category)
        <a href="{{ route('products.show', [$product->category->slug, $product->slug]) }}" target="_blank" class="btn-admin btn-admin-outline">
            View Live Page ↗
        </a>
        @endif
        <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-outline">
            ← Back to Catalogue
        </a>
    </div>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="product-form">
    @csrf
    @method('PUT')

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;align-items:start">
        <!-- Main Column -->
        <div style="display:flex;flex-direction:column;gap:24px">
            <!-- Basic Information -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">General Information</h2>
                </div>
                <div class="admin-card-body">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-name">Product Name *</label>
                        <input type="text" id="prod-name" name="name" class="admin-form-control" value="{{ old('name', $product->name) }}" required>
                        @error('name')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-short-desc">Short Summary</label>
                        <textarea id="prod-short-desc" name="short_description" class="admin-form-control" style="min-height:75px">{{ old('short_description', $product->short_description) }}</textarea>
                        @error('short_description')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-desc">Full Description</label>
                        <textarea id="prod-desc" name="description" class="admin-form-control" style="min-height:160px">{{ old('description', $product->description) }}</textarea>
                        @error('description')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Existing Image Gallery Management -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Manage Product Images ({{ $product->images->count() }})</h2>
                        <p style="font-size:0.75rem;color:var(--admin-muted)">Set primary image or remove outdated photos</p>
                    </div>
                </div>
                <div class="admin-card-body">
                    @if($product->images->count() > 0)
                    <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(140px, 1fr));gap:16px;margin-bottom:20px">
                        @foreach($product->images as $img)
                        <div style="position:relative;border-radius:10px;overflow:hidden;border:2px solid {{ $img->is_primary ? 'var(--admin-gold)' : 'var(--admin-border)' }};background:#000">
                            <div style="aspect-ratio:1;overflow:hidden">
                                <img src="{{ $img->url }}" alt="Product Image" style="width:100%;height:100%;object-fit:cover">
                            </div>
                            @if($img->is_primary)
                                <div style="position:absolute;top:6px;left:6px;background:var(--admin-gold);color:#000;font-size:0.65rem;font-weight:700;padding:2px 8px;border-radius:4px">
                                    Primary
                                </div>
                            @endif
                            <div style="padding:8px;background:var(--admin-sidebar);display:flex;justify-content:space-between;align-items:center;gap:4px">
                                @if(!$img->is_primary)
                                    <button type="button" onclick="document.getElementById('set-primary-form-{{ $img->id }}').submit()" class="btn-admin btn-admin-outline btn-admin-sm" style="font-size:0.7rem;padding:3px 6px" title="Set as primary image">
                                        Make Main
                                    </button>
                                @else
                                    <span style="font-size:0.7rem;color:var(--admin-gold);font-weight:600">Main Photo</span>
                                @endif

                                <button type="button" onclick="if(confirm('Delete this image?')) document.getElementById('delete-img-form-{{ $img->id }}').submit()" class="btn-admin btn-admin-danger btn-admin-sm" style="padding:3px 8px;font-size:0.7rem" title="Delete image">
                                    ✕
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                        <div style="text-align:center;padding:20px;color:var(--admin-muted);font-size:0.85rem">
                            No images uploaded yet. Upload product photos below.
                        </div>
                    @endif

                    <div style="border-top:1px solid var(--admin-border);padding-top:16px">
                        <label class="admin-form-label">Upload Additional Images</label>
                        <div class="img-upload-area" onclick="document.getElementById('product-images').click()">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--admin-gold)" stroke-width="1.5" style="margin:0 auto 6px;display:block"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                            <div style="font-family:'Outfit',sans-serif;font-weight:600;font-size:0.88rem">Click to add more photos</div>
                        </div>
                        <input type="file" name="images[]" id="product-images" multiple accept="image/*" style="display:none" onchange="handleMultipleImages(this)">
                        <div id="images-preview-grid" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(90px, 1fr));gap:10px;margin-top:12px"></div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Specifications Builder -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Technical Specifications</h2>
                        <p style="font-size:0.75rem;color:var(--admin-muted)">Add or modify dimension, materials, capacity, electrical specs</p>
                    </div>
                    <button type="button" class="btn-admin btn-admin-outline btn-admin-sm" onclick="addSpecRow()">
                        + Add Specification
                    </button>
                </div>
                <div class="admin-card-body">
                    <div id="specs-container" style="display:flex;flex-direction:column;gap:10px">
                        @forelse($product->specifications as $spec)
                        <div class="spec-row" style="display:grid;grid-template-columns:1fr 1fr 40px;gap:12px;align-items:center">
                            <input type="text" name="spec_keys[]" class="admin-form-control" value="{{ $spec->spec_key }}" placeholder="Key (e.g. Dimensions)">
                            <input type="text" name="spec_values[]" class="admin-form-control" value="{{ $spec->spec_value }}" placeholder="Value (e.g. 1500 x 800 mm)">
                            <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px">✕</button>
                        </div>
                        @empty
                        <div class="spec-row" style="display:grid;grid-template-columns:1fr 1fr 40px;gap:12px;align-items:center">
                            <input type="text" name="spec_keys[]" class="admin-form-control" placeholder="Key (e.g. Dimensions)">
                            <input type="text" name="spec_values[]" class="admin-form-control" placeholder="Value">
                            <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px">✕</button>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Key Highlights & Features</h2>
                        <p style="font-size:0.75rem;color:var(--admin-muted)">Bullet points displayed on product detail page</p>
                    </div>
                    <button type="button" class="btn-admin btn-admin-outline btn-admin-sm" onclick="addFeatureRow()">
                        + Add Feature
                    </button>
                </div>
                <div class="admin-card-body">
                    <div id="features-container" style="display:flex;flex-direction:column;gap:10px">
                        @php
                            $featuresList = is_array($product->features) ? $product->features : json_decode($product->features ?? '[]', true);
                        @endphp
                        @forelse($featuresList as $feat)
                        <div class="feature-row" style="display:grid;grid-template-columns:1fr 40px;gap:12px;align-items:center">
                            <input type="text" class="admin-form-control feature-input" value="{{ $feat }}" placeholder="Highlight feature...">
                            <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px">✕</button>
                        </div>
                        @empty
                        <div class="feature-row" style="display:grid;grid-template-columns:1fr 40px;gap:12px;align-items:center">
                            <input type="text" class="admin-form-control feature-input" placeholder="e.g. CNC laser cut industrial panels">
                            <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px">✕</button>
                        </div>
                        @endforelse
                    </div>
                    <input type="hidden" name="features" id="features-json">
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div style="display:flex;flex-direction:column;gap:24px">
            <!-- Publish Settings -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Publish & Categorization</h2>
                </div>
                <div class="admin-card-body">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-cat">Category *</label>
                        <select id="prod-cat" name="category_id" class="admin-form-control" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-sort">Sort Order</label>
                        <input type="number" id="prod-sort" name="sort_order" class="admin-form-control" value="{{ old('sort_order', $product->sort_order) }}" min="0">
                    </div>

                    <div style="display:flex;flex-direction:column;gap:12px;margin:16px 0">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Featured on Homepage</span>
                        </label>

                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Active (Publicly Visible)</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-admin btn-admin-primary" style="width:100%;justify-content:center;padding:12px;margin-top:10px">
                        Update Product
                    </button>
                </div>
            </div>

            <!-- SEO Card -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Search Engine Optimization</h2>
                </div>
                <div class="admin-card-body">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-meta-title">SEO Title</label>
                        <input type="text" id="prod-meta-title" name="meta_title" class="admin-form-control" value="{{ old('meta_title', $product->meta_title) }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-meta-desc">Meta Description</label>
                        <textarea id="prod-meta-desc" name="meta_description" class="admin-form-control" style="min-height:80px">{{ old('meta_description', $product->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Hidden auxiliary forms for image primary / delete operations -->
@foreach($product->images as $img)
    <form id="set-primary-form-{{ $img->id }}" action="{{ route('admin.products.images.set-primary', $img->id) }}" method="POST" style="display:none">
        @csrf
    </form>
    <form id="delete-img-form-{{ $img->id }}" action="{{ route('admin.products.images.delete', $img->id) }}" method="POST" style="display:none">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<script>
function addSpecRow() {
    const container = document.getElementById('specs-container');
    const div = document.createElement('div');
    div.className = 'spec-row';
    div.style = 'display:grid;grid-template-columns:1fr 1fr 40px;gap:12px;align-items:center';
    div.innerHTML = `
        <input type="text" name="spec_keys[]" class="admin-form-control" placeholder="Key (e.g. Dimensions)">
        <input type="text" name="spec_values[]" class="admin-form-control" placeholder="Value">
        <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px">✕</button>
    `;
    container.appendChild(div);
}

function addFeatureRow() {
    const container = document.getElementById('features-container');
    const div = document.createElement('div');
    div.className = 'feature-row';
    div.style = 'display:grid;grid-template-columns:1fr 40px;gap:12px;align-items:center';
    div.innerHTML = `
        <input type="text" class="admin-form-control feature-input" placeholder="e.g. Custom LED illuminated signboards">
        <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px">✕</button>
    `;
    container.appendChild(div);
}

function removeRow(btn) {
    btn.parentElement.remove();
}

function handleMultipleImages(input) {
    const grid = document.getElementById('images-preview-grid');
    grid.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const card = document.createElement('div');
                card.style = 'position:relative;aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid var(--admin-border);background:#000';
                card.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover">`;
                grid.appendChild(card);
            }
            reader.readAsDataURL(file);
        });
    }
}

document.getElementById('product-form').addEventListener('submit', function() {
    const features = [];
    document.querySelectorAll('.feature-input').forEach(input => {
        if (input.value.trim()) {
            features.push(input.value.trim());
        }
    });
    document.getElementById('features-json').value = JSON.stringify(features);
});
</script>
@endsection
