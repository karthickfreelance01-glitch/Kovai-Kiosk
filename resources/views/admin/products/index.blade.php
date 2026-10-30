@extends('layouts.admin')
@section('title', 'Products')
@section('page-title', 'Product Catalogue')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Manufacturing Products</h1>
        <p class="page-head-sub">Manage kiosks, mobile push carts, and custom EV units in your master catalogue.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-admin btn-admin-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add New Product
    </a>
</div>

<!-- Filter Bar -->
<form action="{{ route('admin.products.index') }}" method="GET" class="filter-bar">
    <div class="admin-form-group">
        <label class="admin-form-label" for="search-input">Search Product</label>
        <input type="text" id="search-input" name="search" class="admin-form-control" value="{{ request('search') }}" placeholder="Name or keyword...">
    </div>

    <div class="admin-form-group">
        <label class="admin-form-label" for="filter-category">Category</label>
        <select id="filter-category" name="category_id" class="admin-form-control">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="admin-form-group">
        <label class="admin-form-label" for="filter-status">Status</label>
        <select id="filter-status" name="status" class="admin-form-control">
            <option value="">All Statuses</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
        </select>
    </div>

    <div style="display:flex;gap:8px">
        <button type="submit" class="btn-admin btn-admin-primary">Filter</button>
        @if(request()->hasAny(['search', 'category_id', 'status']))
            <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-outline">Reset</a>
        @endif
    </div>
</form>

<!-- Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Catalogue Products ({{ $products->total() }})</h2>
        <span style="font-size:0.75rem;color:var(--admin-muted)">Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }}</span>
    </div>
    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:70px">Photo</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Specifications</th>
                    <th>Order</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div style="width:52px;height:44px;border-radius:6px;overflow:hidden;border:1px solid var(--admin-border);background:rgba(255,255,255,0.04);display:flex;align-items:center;justify-content:center">
                            @if($product->primary_image)
                                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover">
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--admin-muted)"><rect x="3" y="3" width="18" height="13" rx="2"/></svg>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:0.92rem">{{ $product->name }}</div>
                        <div style="font-size:0.72rem;color:var(--admin-muted);margin-top:2px">
                            <code>/products/{{ optional($product->category)->slug }}/{{ $product->slug }}</code>
                        </div>
                    </td>
                    <td>
                        <span class="badge-status" style="background:rgba(201,168,76,0.12);color:var(--admin-gold)">
                            {{ optional($product->category)->name ?? 'Unassigned' }}
                        </span>
                    </td>
                    <td>
                        <span style="font-size:0.8rem;color:var(--admin-muted)">
                            {{ $product->specifications->count() }} specs defined
                        </span>
                    </td>
                    <td>
                        <span style="font-weight:600;color:var(--admin-muted)">#{{ $product->sort_order }}</span>
                    </td>
                    <td>
                        @if($product->is_featured)
                            <span class="badge-status" style="background:rgba(201,168,76,0.15);color:var(--admin-gold)">★ Featured</span>
                        @else
                            <span style="color:var(--admin-muted);font-size:0.75rem">—</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.products.toggle-status', $product->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" style="background:none;border:none;cursor:pointer;padding:0">
                                @if($product->is_active)
                                    <span class="badge-status badge-active">Active</span>
                                @else
                                    <span class="badge-status badge-inactive">Inactive</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td style="text-align:right">
                        <div style="display:inline-flex;gap:8px">
                            @if($product->category)
                            <a href="{{ route('products.show', [$product->category->slug, $product->slug]) }}" target="_blank" class="btn-admin btn-admin-outline btn-admin-sm" title="Preview Product">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            </a>
                            @endif
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this product and all associated images?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:var(--admin-muted)">
                        No products found matching your filter criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div style="padding:20px;border-top:1px solid var(--admin-border)">
        {{ $products->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
