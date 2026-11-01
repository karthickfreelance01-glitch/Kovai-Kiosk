@extends('layouts.admin')
@section('title', 'Edit Hero Slide')
@section('page-title', 'Edit Hero Slide')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Edit Hero Slide #{{ $slider->id }}</h1>
        <p class="page-head-sub">Update slide text, product category, order, status, or replace image.</p>
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('home') }}" target="_blank" class="btn-admin btn-admin-outline" title="Preview on homepage">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/></svg>
            View Live Site
        </a>
        <a href="{{ route('admin.hero-sliders.index') }}" class="btn-admin btn-admin-outline">
            ← Back to Hero Sliders
        </a>
    </div>
</div>

<div style="max-width:920px">
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Modify Slide Details</h2>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.hero-sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data" id="hero-slider-edit-form">
                @csrf
                @method('PUT')

                <!-- Title & Category Row -->
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="slider-title">Slider Title *</label>
                        <input type="text" id="slider-title" name="title" class="admin-form-control" value="{{ old('title', $slider->title) }}" required placeholder="e.g. Next-Gen Smart Interactive Kiosks">
                        @error('title')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="slider-category">Product Category *</label>
                        <select id="slider-category" name="category" class="admin-form-control">
                            <option value="">-- Select Category --</option>
                            <option value="Smart Kiosk" {{ old('category', $slider->category) == 'Smart Kiosk' ? 'selected' : '' }}>Smart Kiosk</option>
                            <option value="Push Cart" {{ old('category', $slider->category) == 'Push Cart' ? 'selected' : '' }}>Push Cart</option>
                            <option value="EV Vehicles" {{ old('category', $slider->category) == 'EV Vehicles' ? 'selected' : '' }}>EV Vehicles</option>
                        </select>
                        @error('category')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Subtitle Row -->
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="slider-subtitle">Subtitle / Badge Note (Optional)</label>
                        <input type="text" id="slider-subtitle" name="subtitle" class="admin-form-control" value="{{ old('subtitle', $slider->subtitle) }}" placeholder="e.g. Commercial Grade Self-Service Experience">
                        @error('subtitle')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="slider-order">Display Order</label>
                        <input type="number" id="slider-order" name="display_order" class="admin-form-control" value="{{ old('display_order', $slider->display_order) }}" min="0">
                        <small style="color:var(--admin-muted);font-size:0.75rem">Lower numbers (0, 1, 2...) appear first in the slider rotation.</small>
                        @error('display_order')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="admin-form-group">
                    <label class="admin-form-label" for="slider-desc">Description (Optional)</label>
                    <textarea id="slider-desc" name="description" class="admin-form-control" style="min-height:90px" placeholder="Brief tagline or highlight of this featured product configuration...">{{ old('description', $slider->description) }}</textarea>
                    @error('description')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <!-- CTA Button Settings -->
                <div class="admin-form-row" style="background:rgba(255,255,255,0.02);padding:16px;border-radius:8px;border:1px solid var(--admin-border);margin-bottom:20px">
                    <div class="admin-form-group" style="margin-bottom:0">
                        <label class="admin-form-label" for="slider-btn-text">Button CTA Text (Optional)</label>
                        <input type="text" id="slider-btn-text" name="button_text" class="admin-form-control" value="{{ old('button_text', $slider->button_text) }}" placeholder="e.g. Explore Smart Kiosks">
                        @error('button_text')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group" style="margin-bottom:0">
                        <label class="admin-form-label" for="slider-btn-url">Button Target URL (Optional)</label>
                        <input type="text" id="slider-btn-url" name="button_url" class="admin-form-control" value="{{ old('button_url', $slider->button_url) }}" placeholder="e.g. /products/smart-kiosk or #enquiry">
                        @error('button_url')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Current Image & Replace Image -->
                <div class="admin-form-group">
                    <label class="admin-form-label">Slider Showcase Image</label>
                    
                    <div style="display:flex;gap:20px;flex-wrap:wrap;align-items:flex-start;margin-bottom:12px">
                        @if($slider->image_url)
                        <div style="background:rgba(255,255,255,0.03);padding:10px;border-radius:10px;border:1px solid var(--admin-border);text-align:center">
                            <div style="font-size:0.75rem;color:var(--admin-gold);font-weight:600;margin-bottom:6px">Current Saved Image</div>
                            <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" style="max-height:160px;border-radius:8px;border:1px solid rgba(255,255,255,0.1);object-fit:cover">
                        </div>
                        @endif

                        <div style="flex:1;min-width:280px">
                            <div class="img-upload-area" id="drop-area" onclick="document.getElementById('slider-image-input').click()">
                                <input type="file" name="image" id="slider-image-input" class="admin-form-control" accept="image/jpeg,image/png,image/webp,image/jpg" style="display:none" onchange="handleImageSelect(this)">
                                <div id="upload-placeholder">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--admin-gold)" stroke-width="1.5" style="margin-bottom:8px"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    <div style="font-weight:600;font-size:0.9rem;color:var(--admin-text);margin-bottom:4px">Click or drag new image to replace</div>
                                    <div style="font-size:0.75rem;color:var(--admin-muted)">Leave empty to keep existing image • Max 5 MB (JPG, PNG, WebP)</div>
                                </div>
                                <div id="image-preview-container" style="display:none;margin-top:10px">
                                    <div style="position:relative;display:inline-block">
                                        <div style="font-size:0.75rem;color:#10B981;font-weight:600;margin-bottom:4px">✓ New Replacement Preview</div>
                                        <img id="image-preview" src="" alt="Replacement Preview" style="max-height:180px;border-radius:10px;border:2px solid var(--admin-green);box-shadow:0 8px 24px rgba(0,0,0,0.5);object-fit:cover">
                                        <div id="file-info-badge" style="margin-top:6px;font-size:0.72rem;color:var(--admin-green)"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('image')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <!-- Active Status Toggle -->
                <div class="admin-form-group" style="margin-top:20px;padding-top:16px;border-top:1px solid var(--admin-border)">
                    <label style="display:flex;align-items:center;gap:12px;cursor:pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slider->is_active ? '1' : '0') == '1' ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:18px;height:18px">
                        <div>
                            <span style="font-size:0.9rem;font-weight:600;color:var(--admin-text)">Active Slide</span>
                            <div style="font-size:0.75rem;color:var(--admin-muted)">When active, this slide is displayed on the public homepage. Uncheck to temporarily hide it.</div>
                        </div>
                    </label>
                </div>

                <!-- Actions -->
                <div style="display:flex;gap:12px;margin-top:28px">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Update Hero Slide
                    </button>
                    <a href="{{ route('admin.hero-sliders.index') }}" class="btn-admin btn-admin-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function handleImageSelect(input) {
    const previewContainer = document.getElementById('image-preview-container');
    const previewImg = document.getElementById('image-preview');
    const fileInfoBadge = document.getElementById('file-info-badge');
    const placeholder = document.getElementById('upload-placeholder');

    if (input.files && input.files[0]) {
        const file = input.files[0];

        // 5MB limit check
        if (file.size > 5 * 1024 * 1024) {
            alert('File exceeds 5MB limit. Please select an image under 5MB.');
            input.value = '';
            previewContainer.style.display = 'none';
            placeholder.style.display = 'block';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            fileInfoBadge.textContent = file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
            previewContainer.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}

// Drag & drop handlers
const dropArea = document.getElementById('drop-area');
['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropArea.style.borderColor = 'var(--admin-gold)';
        dropArea.style.background = 'rgba(201,168,76,0.05)';
    }, false);
});
['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropArea.style.borderColor = '';
        dropArea.style.background = '';
    }, false);
});
dropArea.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    const files = dt.files;
    if (files && files[0]) {
        const input = document.getElementById('slider-image-input');
        input.files = files;
        handleImageSelect(input);
    }
});
</script>
@endsection

