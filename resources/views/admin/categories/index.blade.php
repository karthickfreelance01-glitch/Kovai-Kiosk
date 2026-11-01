@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Category Management')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Product Categories</h1>
        <p class="page-head-sub">Manage your manufacturing product categories shown on website headers, navigation, and catalogues.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-admin btn-admin-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add New Category
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">All Categories ({{ $categories->total() }})</h2>
        <span style="font-size:0.75rem;color:var(--admin-muted)">Display Order controls header & navigation placement</span>
    </div>
    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:70px">Image</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Products Count</th>
                    <th>Order</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        @if($category->image)
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" style="width:50px;height:40px;object-fit:cover;border-radius:6px;border:1px solid var(--admin-border)">
                        @else
                            <div style="width:50px;height:40px;background:var(--admin-bg);border:1px solid var(--admin-border);border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--admin-muted)">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:0.95rem">{{ $category->name }}</div>
                        @if($category->description)
                            <div style="font-size:0.75rem;color:var(--admin-muted);max-width:320px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                {{ $category->description }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <code style="font-size:0.78rem;color:var(--admin-gold);background:rgba(201,168,76,0.1);padding:2px 6px;border-radius:4px">
                            {{ $category->slug }}
                        </code>
                    </td>
                    <td>
                        <span style="font-weight:600">{{ $category->products_count }}</span> products
                    </td>
                    <td>
                        <span style="font-weight:600;color:var(--admin-muted)">#{{ $category->sort_order }}</span>
                    </td>
                    <td>
                        @if($category->is_featured)
                            <span class="badge-status" style="background:rgba(201,168,76,0.15);color:var(--admin-gold)">★ Featured</span>
                        @else
                            <span style="color:var(--admin-muted);font-size:0.75rem">—</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.categories.toggle-status', $category->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" style="background:none;border:none;cursor:pointer;padding:0">
                                @if($category->is_active)
                                    <span class="badge-status badge-active">Active</span>
                                @else
                                    <span class="badge-status badge-inactive">Inactive</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td style="text-align:right">
                        <div style="display:inline-flex;gap:8px">
                            <a href="{{ route('products.category', $category->slug) }}" target="_blank" class="btn-admin btn-admin-outline btn-admin-sm" title="View on website">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                        No categories found. Click "Add New Category" to create one.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div style="padding:20px;border-top:1px solid var(--admin-border)">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
