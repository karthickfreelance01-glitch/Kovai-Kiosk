@extends('layouts.admin')
@section('title', 'About Pathy Product Showcase')
@section('page-title', 'About Pathy – 3D Overlapping Product Carousel')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">About Pathy – Query Loop 3D Product Carousel</h1>
        <p class="page-head-sub">Curate and order the products featured in the 3D overlapping product cards carousel on the About Pathy page.</p>
    </div>
    <a href="{{ route('about') }}#about-showcase" target="_blank" class="btn-admin btn-admin-outline" title="View on live About Pathy page">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/></svg>
        View Live Showcase
    </a>
</div>

<div style="display:grid;grid-template-columns:360px 1fr;gap:24px;align-items:start">
    <!-- Left: Add Product to Showcase Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Add Product to Showcase</h2>
            <span style="font-size:0.75rem;color:var(--admin-muted)">Pulls directly from your existing product catalogue</span>
        </div>
        <div class="admin-card-body">
            @if($availableProducts->isEmpty())
                <div style="text-align:center;padding:20px;color:var(--admin-muted);font-size:0.85rem">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:8px;opacity:0.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <p>All active catalogue products have already been added to the showcase!</p>
                </div>
            @else
            <form action="{{ route('admin.about-showcase.store') }}" method="POST">
                @csrf

                <div class="admin-form-group">
                    <label class="admin-form-label" for="product_id">Select Catalogue Product *</label>
                    <select name="product_id" id="product_id" class="admin-form-control" required onchange="updateProductPreview(this)">
                        <option value="">-- Choose a Product --</option>
                        @foreach($availableProducts as $prod)
                            <option value="{{ $prod->id }}"
                                data-img="{{ $prod->primary_image_url }}"
                                data-cat="{{ optional($prod->category)->name }}"
                                data-desc="{{ $prod->short_description ?? Str::limit($prod->description, 70) }}">
                                {{ $prod->name }} ({{ optional($prod->category)->name ?? 'Uncategorized' }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <!-- Live Selection Preview -->
                <div id="product-selection-preview" style="display:none;background:rgba(255,255,255,0.03);border:1px solid var(--admin-border);border-radius:10px;padding:12px;margin-bottom:16px">
                    <div style="display:flex;gap:12px;align-items:center">
                        <img id="preview-img" src="" alt="Product Preview" style="width:60px;height:50px;object-fit:cover;border-radius:6px;border:1px solid var(--admin-border)">
                        <div>
                            <div id="preview-cat" style="font-size:0.7rem;color:var(--admin-gold);font-weight:700;text-transform:uppercase"></div>
                            <div id="preview-desc" style="font-size:0.75rem;color:var(--admin-muted);line-height:1.3;margin-top:2px"></div>
                        </div>
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="custom_badge">Custom Badge / Tag (Optional)</label>
                    <input type="text" id="custom_badge" name="custom_badge" class="admin-form-control" placeholder="e.g. Signature Model, Flagship, Best Seller">
                    @error('custom_badge')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="display_order">Display Order</label>
                    <input type="number" id="display_order" name="display_order" class="admin-form-control" value="0" min="0">
                    <small style="color:var(--admin-muted);font-size:0.75rem">Determines position in the 3D rotating carousel.</small>
                    @error('display_order')<div class="admin-form-error">{{ $message }}</div>@enderror
                </div>

                <div class="admin-form-group">
                    <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                        <input type="checkbox" name="is_active" value="1" checked style="accent-color:var(--admin-gold);width:16px;height:16px">
                        <span style="font-size:0.85rem;font-weight:600">Active (Visible in 3D Carousel)</span>
                    </label>
                </div>

                <button type="submit" class="btn-admin btn-admin-primary" style="width:100%">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add to About Carousel
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Right: Current Showcase Items Table -->
    <div class="admin-card">
        <div class="admin-card-header" style="display:flex;align-items:center;justify-content:space-between">
            <div>
                <h2 class="admin-card-title">Curated Carousel Products ({{ $showcaseItems->total() }})</h2>
                <span style="font-size:0.75rem;color:var(--admin-muted)">The center card is highlighted in the foreground; adjacent cards peek in 3D perspective.</span>
            </div>
            <div style="font-size:0.75rem;color:var(--admin-gold)">
                Query Loop Integration Active
            </div>
        </div>

        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width:80px">Image</th>
                        <th>Product Details</th>
                        <th>Category</th>
                        <th>Custom Tag</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($showcaseItems as $item)
                    <tr>
                        <td>
                            @php
                                $imgUrl = optional($item->product)->primary_image_url;
                            @endphp
                            <div style="width:70px;height:50px;border-radius:8px;overflow:hidden;border:1px solid var(--admin-border);background:#12141c">
                                @if($imgUrl)
                                    <img src="{{ $imgUrl }}" alt="{{ optional($item->product)->name }}" style="width:100%;height:100%;object-fit:cover" onerror="this.onerror=null;this.parentElement.innerHTML='<div style=\'display:flex;align-items:center;justify-content:center;height:100%;color:var(--admin-muted);font-size:10px\'>No Image</div>'">
                                @else
                                    <div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--admin-muted);font-size:10px">No Image</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:0.92rem;color:var(--admin-text)">
                                {{ optional($item->product)->name ?? 'Product Deleted' }}
                            </div>
                            <div style="font-size:0.75rem;color:var(--admin-muted);line-height:1.3;margin-top:2px">
                                {{ Str::limit(optional($item->product)->short_description ?? optional($item->product)->description, 60) }}
                            </div>
                        </td>
                        <td>
                            @php
                                $catName = optional($item->product->category)->name;
                                $catColors = [
                                    'Smart Kiosk' => ['bg' => 'rgba(59,130,246,0.15)', 'color' => '#93C5FD'],
                                    'Push Cart'   => ['bg' => 'rgba(245,158,11,0.15)', 'color' => '#FCD34D'],
                                    'EV Vehicles' => ['bg' => 'rgba(16,185,129,0.15)', 'color' => '#6EE7B7'],
                                ];
                                $style = $catColors[$catName] ?? ['bg' => 'rgba(255,255,255,0.08)', 'color' => 'var(--admin-text)'];
                            @endphp
                            <span class="badge-status" style="background:{{ $style['bg'] }};color:{{ $style['color'] }}">
                                {{ $catName ?? 'General' }}
                            </span>
                        </td>
                        <td>
                            @if($item->custom_badge)
                                <span style="font-size:0.75rem;color:var(--admin-gold);background:rgba(201,168,76,0.1);padding:3px 8px;border-radius:4px;border:1px solid rgba(201,168,76,0.25)">
                                    ★ {{ $item->custom_badge }}
                                </span>
                            @else
                                <span style="color:var(--admin-muted);font-size:0.75rem">—</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.about-showcase.update', $item->id) }}" method="POST" style="display:inline-flex;align-items:center;gap:6px">
                                @csrf
                                @method('PUT')
                                <input type="number" name="display_order" value="{{ $item->display_order }}" min="0" style="width:50px;padding:4px 6px;border-radius:4px;background:rgba(255,255,255,0.05);border:1px solid var(--admin-border);color:var(--admin-text);font-size:0.8rem">
                                <button type="submit" class="btn-admin btn-admin-outline btn-admin-sm" title="Save order" style="padding:4px 8px">
                                    ✓
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.about-showcase.toggle-status', $item->id) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" title="Click to toggle status" style="background:none;border:none;cursor:pointer;padding:0">
                                    @if($item->is_active)
                                        <span class="badge-status badge-active" style="cursor:pointer">● Active</span>
                                    @else
                                        <span class="badge-status badge-inactive" style="cursor:pointer">○ Inactive</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td style="text-align:right">
                            <div style="display:inline-flex;gap:6px">
                                @if($item->product && $item->product->category)
                                <a href="{{ route('products.show', [$item->product->category->slug, $item->product->slug]) }}" target="_blank" class="btn-admin btn-admin-outline btn-admin-sm" title="View Product Page">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/></svg>
                                </a>
                                @endif
                                <form action="{{ route('admin.about-showcase.destroy', $item->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Remove this product from the About Pathy carousel? The product itself will not be deleted.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm" title="Remove from showcase">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:40px 20px">
                            <div style="width:54px;height:54px;margin:0 auto 12px;border-radius:50%;background:rgba(201,168,76,0.1);display:flex;align-items:center;justify-content:center;color:var(--admin-gold)">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><polyline points="7 10 12 7 17 10"/></svg>
                            </div>
                            <h3 style="font-family:'Outfit',sans-serif;font-size:1.05rem;font-weight:600;margin-bottom:6px">No Specific Products Curated Yet</h3>
                            <p style="font-size:0.82rem;color:var(--admin-muted);max-width:380px;margin:0 auto 16px">
                                When this list is empty, the About Pathy page automatically queries the latest active catalogue products via the Query Loop. Select products on the left to pin and order specific models!
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($showcaseItems->hasPages())
        <div style="padding:16px 24px;border-top:1px solid var(--admin-border)">
            {{ $showcaseItems->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function updateProductPreview(select) {
    const selectedOption = select.options[select.selectedIndex];
    const previewBox = document.getElementById('product-selection-preview');
    const previewImg = document.getElementById('preview-img');
    const previewCat = document.getElementById('preview-cat');
    const previewDesc = document.getElementById('preview-desc');

    if (select.value) {
        previewImg.src = selectedOption.dataset.img || '';
        previewCat.textContent = selectedOption.dataset.cat || '';
        previewDesc.textContent = selectedOption.dataset.desc || '';
        previewBox.style.display = 'block';
    } else {
        previewBox.style.display = 'none';
    }
}
</script>
@endsection

