@extends('layouts.admin')
@section('title', 'Add Hero Slide')
@section('page-title', 'Create Hero Slide')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Add New Hero Slide</h1>
        <p class="page-head-sub">Create an animated 3D visual slide for the homepage hero showcase.</p>
    </div>
    <a href="{{ route('admin.hero-sliders.index') }}" class="btn-admin btn-admin-outline">
        ← Back to Hero Sliders
    </a>
</div>

<div style="max-width:920px">
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Slide Details & Media</h2>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.hero-sliders.store') }}" method="POST" enctype="multipart/form-data" id="hero-slider-form">
                @csrf

                <!-- Title & Category Row -->
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="slider-title">Slider Title *</label>
                        <input type="text" id="slider-title" name="title" class="admin-form-control" value="{{ old('title') }}" required placeholder="e.g. Next-Gen Smart Interactive Kiosks">
                        @error('title')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="slider-category">Product Category *</label>
                        <select id="slider-category" name="category" class="admin-form-control">
                            <option value="">-- Select Category --</option>
                            <option value="Smart Kiosk" {{ old('category') == 'Smart Kiosk' ? 'selected' : '' }}>Smart Kiosk</option>
                            <option value="Push Cart" {{ old('category') == 'Push Cart' ? 'selected' : '' }}>Push Cart</option>
                            <option value="EV Vehicles" {{ old('category') == 'EV Vehicles' ? 'selected' : '' }}>EV Vehicles</option>
                        </select>
                        @error('category')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Subtitle Row -->
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="slider-subtitle">Subtitle / Badge Note (Optional)</label>
                        <input type="text" id="slider-subtitle" name="subtitle" class="admin-form-control" value="{{ old('subtitle') }}" placeholder="e.g. Commercial Grade Self-Service Experience">
                        @error('subtitle')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="slider-order">Display Order</label>
                        <input type="number" id="slider-order" name="display_order" class="admin-form-control" value="{{ old('display_order', 0) }}" min="0">
                        <small style="color:var(--admin-muted);font-size:0.75rem">Lower numbers (0, 1, 2...) appear first in the slider rotation.</small>
                        @error('display_order')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="admin-form-group">
                    <label class="admin-form-label" for="slider-desc">Description (Optional)</label>
                    <textarea id="slider-desc" name="description" class="admin-form-control" style="min-height:90px" placeholder="Brief tagline or highlight of this featured product configuration...">{{ old('description') }}</textarea>
                    @error('description')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <!-- CTA Button Settings -->
                <div class="admin-form-row" style="background:var(--admin-bg);padding:16px;border-radius:8px;border:1px solid var(--admin-border);margin-bottom:20px">
                    <div class="admin-form-group" style="margin-bottom:0">
                        <label class="admin-form-label" for="slider-btn-text">Button CTA Text (Optional)</label>
                        <input type="text" id="slider-btn-text" name="button_text" class="admin-form-control" value="{{ old('button_text', 'Explore Models') }}" placeholder="e.g. Explore Smart Kiosks">
                        @error('button_text')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="admin-form-group" style="margin-bottom:0">
                        <label class="admin-form-label" for="slider-btn-url">Button Target URL (Optional)</label>
                        <input type="text" id="slider-btn-url" name="button_url" class="admin-form-control" value="{{ old('button_url') }}" placeholder="e.g. /products/smart-kiosk or #enquiry">
                        @error('button_url')<div class="admin-form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Image Upload with Drag & Drop & Live Preview -->
                <div class="admin-form-group">
                    <label class="admin-form-label">Slider Showcase Image *</label>
                    <div class="img-upload-area" id="drop-area" onclick="document.getElementById('slider-image-input').click()">
                        <input type="file" name="image" id="slider-image-input" class="admin-form-control" accept="image/jpeg,image/png,image/webp,image/jpg" style="display:none" onchange="handleImageSelect(this)" required>
                        <div id="upload-placeholder">
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="var(--admin-gold)" stroke-width="1.5" style="margin-bottom:12px"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <div style="font-weight:600;font-size:0.95rem;color:var(--admin-text);margin-bottom:4px">Click or drag image here to upload</div>
                            <div style="font-size:0.78rem;color:var(--admin-muted)">Supports JPG, JPEG, PNG, WebP • Maximum 5 MB • High resolution recommended (4:5 or 16:9)</div>
                        </div>
                        <div id="image-preview-container" style="display:none;margin-top:16px">
                            <div style="position:relative;display:inline-block">
                                <img id="image-preview" src="" alt="Selected Preview" style="max-height:280px;border-radius:12px;border:2px solid var(--admin-gold);box-shadow:0 10px 30px rgba(0,0,0,0.5);object-fit:cover">
                                <div id="file-info-badge" style="margin-top:8px;font-size:0.75rem;color:var(--admin-gold);font-weight:600"></div>
                            </div>
                        </div>
                    </div>
                    @error('image')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <!-- Active Status Toggle -->
                <div class="admin-form-group" style="margin-top:20px;padding-top:16px;border-top:1px solid var(--admin-border)">
                    <label style="display:flex;align-items:center;gap:12px;cursor:pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} style="accent-color:var(--admin-gold);width:18px;height:18px">
                        <div>
                            <span style="font-size:0.9rem;font-weight:600;color:var(--admin-text)">Active Slide</span>
                            <div style="font-size:0.75rem;color:var(--admin-muted)">When active, this slide will automatically be included in the homepage animated rotation.</div>
                        </div>
                    </label>
                </div>

                <!-- Actions -->
                <div style="display:flex;gap:12px;margin-top:28px">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Save Hero Slide
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

