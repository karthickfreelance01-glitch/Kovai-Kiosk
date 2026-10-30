@extends('layouts.admin')
@section('title', 'Enquiry Management CRM')
@section('page-title', 'Enquiries & Lead Management')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Client Enquiries & Quotation Leads</h1>
        <p class="page-head-sub">Review incoming customer requirements, manage quotation progress, and export lead dossiers.</p>
    </div>
    <div style="display:flex;gap:12px">
        <a href="{{ route('admin.enquiries.export', request()->query()) }}" class="btn-admin btn-admin-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
            Export Filtered CSV
        </a>
    </div>
</div>

<!-- Search & Filter Controls -->
<form action="{{ route('admin.enquiries.index') }}" method="GET" class="filter-bar">
    <div class="admin-form-group" style="min-width:200px">
        <label class="admin-form-label" for="search-enquiry">Search Leads</label>
        <input type="text" id="search-enquiry" name="search" class="admin-form-control" value="{{ request('search') }}" placeholder="Name, Phone, Email, Ref #...">
    </div>

    <div class="admin-form-group">
        <label class="admin-form-label" for="filter-status">Pipeline Status</label>
        <select id="filter-status" name="status" class="admin-form-control">
            <option value="">All Statuses</option>
            @foreach($statusOptions as $val => $lbl)
                <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
            @endforeach
        </select>
    </div>

    <div class="admin-form-group">
        <label class="admin-form-label" for="filter-cat">Product Category</label>
        <select id="filter-cat" name="category_id" class="admin-form-control">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="admin-form-group" style="min-width:140px">
        <label class="admin-form-label" for="date-from">From Date</label>
        <input type="date" id="date-from" name="date_from" class="admin-form-control" value="{{ request('date_from') }}">
    </div>

    <div class="admin-form-group" style="min-width:140px">
        <label class="admin-form-label" for="date-to">To Date</label>
        <input type="date" id="date-to" name="date_to" class="admin-form-control" value="{{ request('date_to') }}">
    </div>

    <div style="display:flex;gap:8px">
        <button type="submit" class="btn-admin btn-admin-primary">Filter</button>
        @if(request()->hasAny(['search', 'status', 'category_id', 'date_from', 'date_to']))
            <a href="{{ route('admin.enquiries.index') }}" class="btn-admin btn-admin-outline">Reset</a>
        @endif
    </div>
</form>

<!-- Leads Data Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Enquiry Records ({{ $enquiries->total() }})</h2>
        <span style="font-size:0.75rem;color:var(--admin-muted)">Sorted by newest submission</span>
    </div>
    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Ref #</th>
                    <th>Customer & Company</th>
                    <th>Contact Info</th>
                    <th>Category & Product</th>
                    <th>Qty / Budget</th>
                    <th>Submitted</th>
                    <th>Status</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enquiries as $item)
                <tr>
                    <td>
                        <span style="font-family:'Outfit',sans-serif;font-weight:700;color:var(--admin-gold);font-size:0.82rem">
                            {{ $item->reference_number }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:0.92rem">{{ $item->full_name }}</div>
                        @if($item->company_name)
                            <div style="font-size:0.75rem;color:var(--admin-muted)">🏢 {{ $item->company_name }}</div>
                        @endif
                        @if($item->location)
                            <div style="font-size:0.72rem;color:var(--admin-muted)">📍 {{ $item->location }}</div>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:6px">
                            <a href="tel:{{ $item->mobile_number }}" style="color:var(--admin-text);font-weight:500">
                                {{ $item->mobile_number }}
                            </a>
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $item->mobile_number);
                            @endphp
                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" title="Chat on WhatsApp" style="color:#25D366;display:inline-flex">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.073-2.023-.478-1.574-.652-2.589-2.257-2.67-2.366-.079-.108-.636-.849-.636-1.62 0-.77.404-1.15.548-1.306.144-.156.312-.195.416-.195.104 0 .208.002.299.006.096.004.224-.036.35.267.13.312.445 1.09.484 1.17.039.078.065.17.013.273-.052.104-.078.169-.156.26-.078.091-.163.203-.234.273-.078.078-.16.163-.069.318.091.156.404.667.868 1.079.598.532 1.102.697 1.258.775.156.078.247.065.338-.039.091-.104.39-.455.494-.611.104-.156.208-.13.35-.078.143.052.909.429 1.065.507.156.078.26.117.299.182.039.065.039.377-.105.782z"/></svg>
                            </a>
                        </div>
                        <div style="font-size:0.75rem;color:var(--admin-muted)">
                            <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:500">{{ $item->product_name ?? optional($item->product)->name ?? 'General Inquiry' }}</div>
                        <div style="font-size:0.75rem;color:var(--admin-gold)">{{ optional($item->category)->name ?? 'Uncategorized' }}</div>
                    </td>
                    <td>
                        <div style="font-size:0.85rem">Qty: <strong>{{ $item->quantity }}</strong></div>
                        @if($item->budget_range)
                            <div style="font-size:0.72rem;color:var(--admin-muted)">Budget: {{ $item->budget_range }}</div>
                        @endif
                    </td>
                    <td style="font-size:0.78rem;color:var(--admin-muted)">
                        {{ $item->created_at->format('d M Y') }}<br>
                        <span style="font-size:0.7rem">{{ $item->created_at->format('h:i A') }}</span>
                    </td>
                    <td>
                        <span class="badge-status badge-{{ $item->status }}">
                            {{ $item->status_label }}
                        </span>
                    </td>
                    <td style="text-align:right">
                        <div style="display:inline-flex;gap:6px">
                            <a href="{{ route('admin.enquiries.show', $item->id) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                                View
                            </a>
                            <form action="{{ route('admin.enquiries.destroy', $item->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this enquiry record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm" title="Delete">
                                    ✕
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:var(--admin-muted)">
                        No enquiries matching the filter criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($enquiries->hasPages())
    <div style="padding:20px;border-top:1px solid var(--admin-border)">
        {{ $enquiries->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
