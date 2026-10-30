@extends('layouts.admin')
@section('title', 'Add Product')
@section('page-title', 'Create Product')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Add New Manufacturing Product</h1>
        <p class="page-head-sub">Configure a new kiosk, mobile cart, or EV vehicle with specifications and photo gallery.</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-outline">
        ← Back to Catalogue
    </a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
    @csrf

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
                        <input type="text" id="prod-name" name="name" class="admin-form-control" value="{{ old('name') }}" required placeholder="e.g. Luxury Stainless Food Kiosk">
                        @error('name')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-short-desc">Short Summary</label>
                        <textarea id="prod-short-desc" name="short_description" class="admin-form-control" style="min-height:75px" placeholder="One or two sentences highlighting this kiosk model for cards and quick summaries...">{{ old('short_description') }}</textarea>
                        @error('short_description')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-desc">Full Description</label>
                        <textarea id="prod-desc" name="description" class="admin-form-control" style="min-height:160px" placeholder="Detailed architectural and manufacturing description, materials, application use cases...">{{ old('description') }}</textarea>
                        @error('description')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <!-- Dynamic Specifications Builder -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Technical Specifications</h2>
                        <p style="font-size:0.75rem;color:var(--admin-muted)">Dimensions, materials, load capacity, electrical inputs, etc.</p>
                    </div>
                    <button type="button" class="btn-admin btn-admin-outline btn-admin-sm" onclick="addSpecRow()">
                        + Add Specification
                    </button>
                </div>
                <div class="admin-card-body">
                    <div id="specs-container" style="display:flex;flex-direction:column;gap:10px">
                        <div class="spec-row" style="display:grid;grid-template-columns:1fr 1fr 40px;gap:12px;align-items:center">
                            <input type="text" name="spec_keys[]" class="admin-form-control" placeholder="Key (e.g. Dimensions)" value="Dimensions">
                            <input type="text" name="spec_values[]" class="admin-form-control" placeholder="Value (e.g. 1800 x 900 x 2100 mm)">
                            <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px" title="Remove">✕</button>
                        </div>
                        <div class="spec-row" style="display:grid;grid-template-columns:1fr 1fr 40px;gap:12px;align-items:center">
                            <input type="text" name="spec_keys[]" class="admin-form-control" placeholder="Key (e.g. Primary Material)" value="Primary Material">
                            <input type="text" name="spec_values[]" class="admin-form-control" placeholder="Value (e.g. SS304 Stainless Steel)">
                            <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px" title="Remove">✕</button>
                        </div>
                        <div class="spec-row" style="display:grid;grid-template-columns:1fr 1fr 40px;gap:12px;align-items:center">
                            <input type="text" name="spec_keys[]" class="admin-form-control" placeholder="Key (e.g. Warranty)" value="Warranty">
                            <input type="text" name="spec_values[]" class="admin-form-control" placeholder="Value (e.g. 3 Years Structural)">
                            <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px" title="Remove">✕</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Key Highlights & Features</h2>
                        <p style="font-size:0.75rem;color:var(--admin-muted)">Bullet points shown with luxury star icons on the product showcase page</p>
                    </div>
                    <button type="button" class="btn-admin btn-admin-outline btn-admin-sm" onclick="addFeatureRow()">
                        + Add Feature
                    </button>
                </div>
                <div class="admin-card-body">
                    <div id="features-container" style="display:flex;flex-direction:column;gap:10px">
                        <div class="feature-row" style="display:grid;grid-template-columns:1fr 40px;gap:12px;align-items:center">
                            <input type="text" class="admin-form-control feature-input" placeholder="e.g. CNC laser cut industrial panels">
                            <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px">✕</button>
                        </div>
                        <div class="feature-row" style="display:grid;grid-template-columns:1fr 40px;gap:12px;align-items:center">
                            <input type="text" class="admin-form-control feature-input" placeholder="e.g. Weatherproof electrostatic powder coating">
                            <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="removeRow(this)" style="padding:8px">✕</button>
                        </div>
                    </div>
                    <input type="hidden" name="features" id="features-json">
                </div>
            </div>

            <!-- Image Upload Gallery -->
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-card-title">Product Image Gallery</h2>
                        <p style="font-size:0.75rem;color:var(--admin-muted)">Upload high-resolution photography. The first image will be set as primary.</p>
                    </div>
                </div>
                <div class="admin-card-body">
                    <div class="img-upload-area" onclick="document.getElementById('product-images').click()">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--admin-gold)" stroke-width="1.5" style="margin:0 auto 10px;display:block"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <div style="font-family:'Outfit',sans-serif;font-weight:600;font-size:0.95rem">Click to select product photos</div>
                        <div style="font-size:0.75rem;color:var(--admin-muted);margin-top:4px">PNG, JPG, WEBP up to 4MB each. You can select multiple images at once.</div>
                    </div>
                    <input type="file" name="images[]" id="product-images" multiple accept="image/*" style="display:none" onchange="handleMultipleImages(this)">
                    
                    <div id="images-preview-grid" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(100px, 1fr));gap:12px;margin-top:16px"></div>
                    @error('images.*')<div class="admin-form-error">{{ $message }}</div>@enderror
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
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-sort">Sort Order</label>
                        <input type="number" id="prod-sort" name="sort_order" class="admin-form-control" value="{{ old('sort_order', 1) }}" min="0">
                    </div>

                    <div style="display:flex;flex-direction:column;gap:12px;margin:16px 0">
                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Featured on Homepage</span>
                        </label>

                        <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:16px;height:16px">
                            <span style="font-size:0.85rem;font-weight:600">Active (Publicly Visible)</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-admin btn-admin-primary" style="width:100%;justify-content:center;padding:12px;margin-top:10px">
                        Save Product
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
                        <input type="text" id="prod-meta-title" name="meta_title" class="admin-form-control" value="{{ old('meta_title') }}" placeholder="Custom page title">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="prod-meta-desc">Meta Description</label>
                        <textarea id="prod-meta-desc" name="meta_description" class="admin-form-control" style="min-height:80px" placeholder="Search snippet description...">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function addSpecRow() {
    const container = document.getElementById('specs-container');
    const div = document.createElement('div');
    div.className = 'spec-row';
    div.style = 'display:grid;grid-template-columns:1fr 1fr 40px;gap:12px;align-items:center';
    div.innerHTML = `
        <input type="text" name="spec_keys[]" class="admin-form-control" placeholder="Key (e.g. Dimensions)">
        <input type="text" name="spec_values[]" class="admin-form-control" placeholder="Value (e.g. 1500 x 800 mm)">
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
        <input type="text" class="admin-form-control feature-input" placeholder="e.g. Built-in LED spotlights and cash drawer">
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
        Array.from(input.files).forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const card = document.createElement('div');
                card.style = 'position:relative;aspect-ratio:1;border-radius:8px;overflow:hidden;border:1px solid var(--admin-border);background:#000';
                card.innerHTML = `
                    <img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover">
                    ${idx === 0 ? '<span style="position:absolute;bottom:4px;left:4px;background:var(--admin-gold);color:#000;font-size:0.6rem;font-weight:700;padding:2px 6px;border-radius:4px">Primary</span>' : ''}
                `;
                grid.appendChild(card);
            }
            reader.readAsDataURL(file);
        });
    }
}

// Convert features to JSON before submission
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
