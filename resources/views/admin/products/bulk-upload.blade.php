@extends('layouts.admin')
@section('title', 'Bulk Product Upload')
@section('page-title', 'Bulk Upload Products')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">⚡ Bulk Product & Image Uploader</h1>
        <p class="page-head-sub">Upload 50+ photos in a single click. Automatically creates products with unique slugs.</p>
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-outline">
            ← Back to Catalogue
        </a>
    </div>
</div>

<div style="display:grid;grid-template-columns:360px 1fr;gap:24px;align-items:start">
    <!-- Configuration Sidebar -->
    <div style="display:flex;flex-direction:column;gap:20px">
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">1. Target Category & Mode</h2>
            </div>
            <div class="admin-card-body" style="display:flex;flex-direction:column;gap:16px">
                <div class="admin-form-group">
                    <label class="admin-form-label" for="bulk-category">Select Category *</label>
                    <select id="bulk-category" class="admin-form-control" onchange="onCategoryChange(this)">
                        <option value="">-- Choose Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" data-name="{{ $cat->name }}" {{ (request('category_id') == $cat->id || $loop->first) ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label">Upload Mode</label>
                    <div style="display:flex;flex-direction:column;gap:10px;margin-top:6px">
                        <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;font-size:0.875rem">
                            <input type="radio" name="upload_mode" value="individual_products" checked onchange="toggleMode(this.value)" style="margin-top:3px;accent-color:var(--admin-gold)">
                            <div>
                                <strong style="color:var(--admin-text)">Create 1 Product Per Image</strong>
                                <div style="font-size:0.75rem;color:var(--admin-muted)">e.g. 50 photos = 50 products created with unique slugs (Smart Kiosk, Smart Kiosk 1, 2...)</div>
                            </div>
                        </label>
                        <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;font-size:0.875rem">
                            <input type="radio" name="upload_mode" value="single_gallery" onchange="toggleMode(this.value)" style="margin-top:3px;accent-color:var(--admin-gold)">
                            <div>
                                <strong style="color:var(--admin-text)">Attach All to Single Product</strong>
                                <div style="font-size:0.75rem;color:var(--admin-muted)">Add all uploaded photos into one product's gallery.</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Existing Product Dropdown (Only for single_gallery mode) -->
                <div class="admin-form-group" id="single-product-container" style="display:none">
                    <label class="admin-form-label" for="target-product-id">Target Product *</label>
                    <select id="target-product-id" class="admin-form-control">
                        <option value="">-- Choose Existing Product --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" data-category="{{ $p->category_id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="individual-options">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="base-name">Product Base Name</label>
                        <input type="text" id="base-name" class="admin-form-control" placeholder="e.g. Smart Kiosk">
                        <div style="font-size:0.72rem;color:var(--admin-muted);margin-top:4px">
                            Leave blank or keep category name. Duplicates will auto-number (1, 2, 3..).
                        </div>
                    </div>

                    <div class="admin-form-group" style="margin-top:12px">
                        <label class="admin-form-label">Naming Scheme</label>
                        <div style="display:flex;flex-direction:column;gap:8px;margin-top:6px">
                            <label style="display:flex;align-items:center;gap:8px;font-size:0.85rem;cursor:pointer">
                                <input type="radio" name="naming_mode" value="base_name" checked style="accent-color:var(--admin-gold)">
                                <span>Use Base Name (e.g. Smart Kiosk, Smart Kiosk 1...)</span>
                            </label>
                            <label style="display:flex;align-items:center;gap:8px;font-size:0.85rem;cursor:pointer">
                                <input type="radio" name="naming_mode" value="filename" style="accent-color:var(--admin-gold)">
                                <span>Use Photo Filename (clean name from file)</span>
                            </label>
                        </div>
                    </div>

                    <div class="admin-form-group" style="margin-top:12px">
                        <label class="admin-form-label" for="default-desc">Default Description (Optional)</label>
                        <textarea id="default-desc" class="admin-form-control" style="min-height:70px" placeholder="Optional short description applied to all created products..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload & Queue Area -->
    <div style="display:flex;flex-direction:column;gap:20px">
        <!-- Dropzone Card -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">2. Select Your Photos</h2>
                    <p style="font-size:0.75rem;color:var(--admin-muted)">You can drag and drop 50 or more photos at once (JPG, PNG, WEBP).</p>
                </div>
                <div id="queue-count-badge" style="display:none;background:var(--admin-sidebar-hover);padding:4px 10px;border-radius:20px;font-size:0.8rem;font-weight:600">
                    <span id="selected-count">0</span> photos selected
                </div>
            </div>
            <div class="admin-card-body">
                <div id="drop-area" style="border:2px dashed var(--admin-border);border-radius:12px;padding:36px 20px;text-align:center;cursor:pointer;transition:all 0.2s" onclick="document.getElementById('file-input').click()">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--admin-gold)" stroke-width="1.6" style="margin:0 auto 12px;display:block">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    <h3 style="font-size:1.1rem;font-weight:600;margin-bottom:6px">Drag & Drop Photos Here</h3>
                    <p style="font-size:0.85rem;color:var(--admin-muted);margin-bottom:12px">or click to browse from your computer (Press <strong>Ctrl + A</strong> in folder to select all 50 photos)</p>
                    <span class="btn-admin btn-admin-outline btn-admin-sm">Browse Files</span>
                </div>
                <input type="file" id="file-input" multiple accept="image/*" style="display:none" onchange="handleFilesSelected(this.files)">

                <!-- Progress Bar Section -->
                <div id="progress-container" style="display:none;margin-top:20px;padding:16px;background:var(--admin-sidebar-hover);border-radius:10px">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                        <span id="progress-status-text" style="font-size:0.875rem;font-weight:600">Uploading photos...</span>
                        <span id="progress-percentage" style="font-size:0.875rem;font-weight:700;color:var(--admin-gold)">0%</span>
                    </div>
                    <div style="width:100%;height:10px;background:var(--admin-border);border-radius:5px;overflow:hidden">
                        <div id="progress-bar-fill" style="width:0%;height:100%;background:var(--admin-gold);transition:width 0.2s ease"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-top:8px;font-size:0.75rem;color:var(--admin-muted)">
                        <span>Processed: <strong id="processed-count">0</strong> / <strong id="total-count">0</strong></span>
                        <span>Success: <strong id="success-count" style="color:var(--admin-green)">0</strong> | Failed: <strong id="failed-count" style="color:var(--admin-red)">0</strong></span>
                    </div>
                </div>

                <!-- Single Click Upload Button -->
                <div id="action-bar" style="margin-top:20px;display:none;justify-content:space-between;align-items:center">
                    <button type="button" class="btn-admin btn-admin-danger btn-admin-sm" onclick="clearSelectedQueue()">
                        Clear All
                    </button>
                    <button type="button" id="start-upload-btn" class="btn-admin btn-admin-primary" style="padding:12px 28px;font-size:1rem;font-weight:600" onclick="startBulkUpload()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Upload in Single Click (<span id="btn-count">0</span> Photos)
                    </button>
                </div>
            </div>
        </div>

        <!-- Preview Grid -->
        <div class="admin-card" id="preview-card" style="display:none">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Selected Photos Queue</h2>
                <span id="queue-status-badge" style="font-size:0.75rem;color:var(--admin-muted)">Ready to upload</span>
            </div>
            <div class="admin-card-body">
                <div id="preview-grid" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(130px, 1fr));gap:12px;max-height:450px;overflow-y:auto;padding-right:4px">
                    <!-- Cards will be populated here dynamically -->
                </div>
            </div>
        </div>

        <!-- Completion Card -->
        <div class="admin-card" id="completion-card" style="display:none;border-color:var(--admin-green)">
            <div class="admin-card-body" style="text-align:center;padding:32px 20px">
                <div style="width:54px;height:54px;border-radius:50%;background:rgba(5, 150, 105, 0.15);color:var(--admin-green);display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <h3 style="font-size:1.3rem;font-weight:700;margin-bottom:8px">All Products Uploaded Successfully!</h3>
                <p id="completion-summary" style="font-size:0.9rem;color:var(--admin-muted);margin-bottom:20px">
                    Your photos have been processed and products are live in the catalogue.
                </p>
                <div style="display:flex;gap:12px;justify-content:center">
                    <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-primary">
                        View Products in Catalogue
                    </a>
                    <button type="button" class="btn-admin btn-admin-outline" onclick="resetBulkUploader()">
                        Upload Another Batch (e.g. Push Cart)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let uploadQueue = [];
let isUploading = false;
let processedCount = 0;
let successCount = 0;
let failedCount = 0;

document.addEventListener('DOMContentLoaded', function() {
    const catSelect = document.getElementById('bulk-category');
    if (catSelect && catSelect.value) {
        onCategoryChange(catSelect);
    }

    // Drag and drop handlers
    const dropArea = document.getElementById('drop-area');
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.style.borderColor = 'var(--admin-gold)';
            dropArea.style.background = 'var(--admin-sidebar-hover)';
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.style.borderColor = 'var(--admin-border)';
            dropArea.style.background = 'transparent';
        }, false);
    });

    dropArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        if (dt && dt.files && dt.files.length) {
            handleFilesSelected(dt.files);
        }
    }, false);
});

function onCategoryChange(select) {
    const selectedOpt = select.options[select.selectedIndex];
    const catName = selectedOpt ? selectedOpt.getAttribute('data-name') : '';
    const baseNameInput = document.getElementById('base-name');
    if (baseNameInput && catName) {
        baseNameInput.value = catName;
    }

    // Filter target products dropdown if in single_gallery mode
    const catId = select.value;
    const targetSelect = document.getElementById('target-product-id');
    if (targetSelect) {
        Array.from(targetSelect.options).forEach(opt => {
            if (!opt.value) return;
            opt.style.display = (opt.getAttribute('data-category') == catId) ? '' : 'none';
        });
    }
}

function toggleMode(mode) {
    const singleContainer = document.getElementById('single-product-container');
    const individualOptions = document.getElementById('individual-options');
    if (mode === 'single_gallery') {
        singleContainer.style.display = 'block';
        individualOptions.style.display = 'none';
    } else {
        singleContainer.style.display = 'none';
        individualOptions.style.display = 'block';
    }
}

function handleFilesSelected(fileList) {
    if (!fileList || !fileList.length) return;

    for (let i = 0; i < fileList.length; i++) {
        const file = fileList[i];
        if (!file.type.startsWith('image/')) continue;
        
        uploadQueue.push({
            id: 'file_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
            file: file,
            status: 'pending', // pending, uploading, success, error
            errorMsg: ''
        });
    }

    renderQueue();
}

function renderQueue() {
    const previewGrid = document.getElementById('preview-grid');
    const previewCard = document.getElementById('preview-card');
    const actionBar = document.getElementById('action-bar');
    const queueBadge = document.getElementById('queue-count-badge');
    const countSpan = document.getElementById('selected-count');
    const btnCount = document.getElementById('btn-count');

    if (!uploadQueue.length) {
        previewCard.style.display = 'none';
        actionBar.style.display = 'none';
        queueBadge.style.display = 'none';
        return;
    }

    previewCard.style.display = 'block';
    actionBar.style.display = 'flex';
    queueBadge.style.display = 'block';
    countSpan.textContent = uploadQueue.length;
    btnCount.textContent = uploadQueue.length;

    previewGrid.innerHTML = '';

    uploadQueue.forEach((item, index) => {
        const card = document.createElement('div');
        card.id = 'card_' + item.id;
        card.style.position = 'relative';
        card.style.borderRadius = '8px';
        card.style.overflow = 'hidden';
        card.style.border = '1px solid var(--admin-border)';
        card.style.background = 'var(--admin-card)';
        card.style.display = 'flex';
        card.style.flexDirection = 'column';

        const img = document.createElement('img');
        img.src = URL.createObjectURL(item.file);
        img.style.width = '100%';
        img.style.height = '90px';
        img.style.objectFit = 'cover';

        const info = document.createElement('div');
        info.style.padding = '6px 8px';
        info.style.fontSize = '0.72rem';
        info.style.whiteSpace = 'nowrap';
        info.style.overflow = 'hidden';
        info.style.textOverflow = 'ellipsis';
        info.textContent = item.file.name;

        const badge = document.createElement('div');
        badge.id = 'status_' + item.id;
        badge.style.position = 'absolute';
        badge.style.top = '4px';
        badge.style.right = '4px';
        badge.style.padding = '2px 6px';
        badge.style.borderRadius = '10px';
        badge.style.fontSize = '0.65rem';
        badge.style.fontWeight = '600';
        badge.style.background = 'rgba(0,0,0,0.6)';
        badge.style.color = '#fff';
        badge.textContent = '#' + (index + 1);

        card.appendChild(img);
        card.appendChild(info);
        card.appendChild(badge);

        if (!isUploading) {
            const delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.innerHTML = '✕';
            delBtn.style.position = 'absolute';
            delBtn.style.top = '4px';
            delBtn.style.left = '4px';
            delBtn.style.width = '20px';
            delBtn.style.height = '20px';
            delBtn.style.borderRadius = '50%';
            delBtn.style.border = 'none';
            delBtn.style.background = 'rgba(220, 38, 38, 0.85)';
            delBtn.style.color = '#fff';
            delBtn.style.cursor = 'pointer';
            delBtn.style.fontSize = '10px';
            delBtn.style.lineHeight = '1';
            delBtn.onclick = (e) => {
                e.stopPropagation();
                uploadQueue = uploadQueue.filter(q => q.id !== item.id);
                renderQueue();
            };
            card.appendChild(delBtn);
        }

        previewGrid.appendChild(card);
    });
}

function clearSelectedQueue() {
    if (isUploading) return;
    uploadQueue = [];
    renderQueue();
}

async function startBulkUpload() {
    if (isUploading || !uploadQueue.length) return;

    const categoryId = document.getElementById('bulk-category').value;
    if (!categoryId) {
        alert('Please select a target Category first.');
        document.getElementById('bulk-category').focus();
        return;
    }

    const mode = document.querySelector('input[name="upload_mode"]:checked').value;
    const productId = document.getElementById('target-product-id').value;

    if (mode === 'single_gallery' && !productId) {
        alert('Please select the Target Product to attach photos to.');
        document.getElementById('target-product-id').focus();
        return;
    }

    isUploading = true;
    document.getElementById('start-upload-btn').disabled = true;
    document.getElementById('start-upload-btn').innerHTML = '⏳ Uploading in progress...';
    document.getElementById('drop-area').style.pointerEvents = 'none';
    document.getElementById('drop-area').style.opacity = '0.5';

    document.getElementById('progress-container').style.display = 'block';
    processedCount = 0;
    successCount = 0;
    failedCount = 0;
    document.getElementById('total-count').textContent = uploadQueue.length;

    const baseName = document.getElementById('base-name').value;
    const namingMode = document.querySelector('input[name="naming_mode"]:checked').value;
    const description = document.getElementById('default-desc').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Process with small concurrency (2 parallel uploads) for maximum speed and rock-solid safety
    const concurrency = 2;
    let queueIndex = 0;

    async function worker() {
        while (queueIndex < uploadQueue.length) {
            const item = uploadQueue[queueIndex++];
            await uploadSingleFile(item, { categoryId, mode, productId, baseName, namingMode, description, csrfToken });
            processedCount++;
            updateProgress();
        }
    }

    const workers = [];
    for (let i = 0; i < Math.min(concurrency, uploadQueue.length); i++) {
        workers.push(worker());
    }

    await Promise.all(workers);

    // Finished
    isUploading = false;
    document.getElementById('progress-status-text').textContent = 'Upload Finished!';
    document.getElementById('completion-card').style.display = 'block';
    document.getElementById('completion-summary').innerHTML = `Successfully processed <strong>${successCount}</strong> product photo(s).`;
    document.getElementById('action-bar').style.display = 'none';
}

async function uploadSingleFile(item, options) {
    const badge = document.getElementById('status_' + item.id);
    const card = document.getElementById('card_' + item.id);

    if (badge) {
        badge.style.background = 'var(--admin-blue)';
        badge.textContent = 'Uploading...';
    }

    const formData = new FormData();
    formData.append('image', item.file);
    formData.append('category_id', options.categoryId);
    formData.append('mode', options.mode);
    if (options.productId) formData.append('product_id', options.productId);
    if (options.baseName) formData.append('base_name', options.baseName);
    formData.append('naming_mode', options.namingMode);
    if (options.description) formData.append('description', options.description);

    try {
        const response = await fetch("{{ route('admin.products.bulk-upload-item') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': options.csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
            item.status = 'success';
            successCount++;
            if (badge) {
                badge.style.background = 'var(--admin-green)';
                badge.textContent = '✓ Done';
            }
            if (card) {
                card.style.borderColor = 'var(--admin-green)';
            }
        } else {
            throw new Error(data.message || 'Upload failed');
        }
    } catch (err) {
        item.status = 'error';
        failedCount++;
        if (badge) {
            badge.style.background = 'var(--admin-red)';
            badge.textContent = '✕ Error';
        }
        if (card) {
            card.style.borderColor = 'var(--admin-red)';
        }
    }
}

function updateProgress() {
    const total = uploadQueue.length;
    const percent = Math.round((processedCount / total) * 100);

    document.getElementById('processed-count').textContent = processedCount;
    document.getElementById('success-count').textContent = successCount;
    document.getElementById('failed-count').textContent = failedCount;
    document.getElementById('progress-bar-fill').style.width = percent + '%';
    document.getElementById('progress-percentage').textContent = percent + '%';
    document.getElementById('progress-status-text').textContent = `Uploading photo ${processedCount} of ${total}...`;
}

function resetBulkUploader() {
    uploadQueue = [];
    processedCount = 0;
    successCount = 0;
    failedCount = 0;
    document.getElementById('drop-area').style.pointerEvents = 'auto';
    document.getElementById('drop-area').style.opacity = '1';
    document.getElementById('progress-container').style.display = 'none';
    document.getElementById('completion-card').style.display = 'none';
    document.getElementById('preview-card').style.display = 'none';
    document.getElementById('action-bar').style.display = 'none';
    document.getElementById('start-upload-btn').disabled = false;
    renderQueue();
}
</script>
@endsection

