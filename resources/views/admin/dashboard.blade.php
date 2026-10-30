@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Executive Dashboard')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Dashboard Overview</h1>
        <p class="page-head-sub">Welcome back, {{ auth()->user()->name }}. Here is a summary of your manufacturing business today.</p>
    </div>
    <div style="display:flex;gap:12px">
        <a href="{{ route('admin.products.create') }}" class="btn-admin btn-admin-primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Product
        </a>
        <a href="{{ route('admin.enquiries.export') }}" class="btn-admin btn-admin-outline">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
            Export Enquiries
        </a>
    </div>
</div>

<!-- Key Metrics Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(201,168,76,0.15);color:var(--admin-gold)">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_products'] }}</div>
            <div class="stat-label">Total Products</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(59,130,246,0.15);color:var(--admin-blue)">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
        </div>
        <div>
            <div class="stat-num">{{ $stats['total_categories'] }}</div>
            <div class="stat-label">Categories</div>
        </div>
    </div>

    <div class="stat-card" style="border-color:rgba(201,168,76,0.4)">
        <div class="stat-icon" style="background:rgba(239,68,68,0.15);color:var(--admin-red)">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        </div>
        <div>
            <div class="stat-num" style="color:var(--admin-gold)">{{ $stats['new_enquiries'] }}</div>
            <div class="stat-label">New Enquiries (Needs Action)</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(16,185,129,0.15);color:var(--admin-green)">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div>
            <div class="stat-num">{{ $stats['converted'] }}</div>
            <div class="stat-label">Converted Clients</div>
        </div>
    </div>
</div>

<!-- Secondary Stats & Quick Actions -->
<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:28px">
    <!-- Enquiries Status Distribution -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Enquiry Pipeline Distribution</h2>
            <span style="font-size:0.75rem;color:var(--admin-muted)">{{ $stats['total_enquiries'] }} Total Received</span>
        </div>
        <div class="admin-card-body">
            @php
                $statusConfig = [
                    'new'            => ['label' => 'New Inquiries', 'color' => '#60A5FA', 'bg' => 'rgba(59,130,246,0.2)'],
                    'contacted'      => ['label' => 'Contacted', 'color' => '#FCD34D', 'bg' => 'rgba(245,158,11,0.2)'],
                    'follow_up'      => ['label' => 'Follow Up', 'color' => '#FB923C', 'bg' => 'rgba(249,115,22,0.2)'],
                    'quotation_sent' => ['label' => 'Quotation Sent', 'color' => '#A78BFA', 'bg' => 'rgba(139,92,246,0.2)'],
                    'converted'      => ['label' => 'Converted Order', 'color' => '#34D399', 'bg' => 'rgba(16,185,129,0.2)'],
                    'closed'         => ['label' => 'Closed / Inactive', 'color' => '#9CA3AF', 'bg' => 'rgba(107,114,128,0.2)'],
                ];
                $total = max(1, $stats['total_enquiries']);
            @endphp

            <!-- Progress Bar Stack -->
            <div style="height:12px;border-radius:6px;overflow:hidden;background:rgba(255,255,255,0.06);display:flex;margin-bottom:24px">
                @foreach($statusConfig as $stKey => $stCfg)
                    @php $cnt = $enquiryByStatus[$stKey] ?? 0; $pct = ($cnt / $total) * 100; @endphp
                    @if($pct > 0)
                        <div style="width:{{ $pct }}%;background:{{ $stCfg['color'] }};transition:width 0.5s" title="{{ $stCfg['label'] }}: {{ $cnt }}"></div>
                    @endif
                @endforeach
            </div>

            <!-- Status Grid -->
            <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:16px">
                @foreach($statusConfig as $stKey => $stCfg)
                    @php $cnt = $enquiryByStatus[$stKey] ?? 0; @endphp
                    <div style="background:rgba(255,255,255,0.02);border:1px solid var(--admin-border);border-radius:8px;padding:12px 14px;border-left:3px solid {{ $stCfg['color'] }}">
                        <div style="font-size:0.75rem;color:var(--admin-muted)">{{ $stCfg['label'] }}</div>
                        <div style="font-family:'Outfit',sans-serif;font-size:1.4rem;font-weight:700;color:{{ $stCfg['color'] }};margin-top:4px">
                            {{ $cnt }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick Navigation Card -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Quick Actions</h2>
        </div>
        <div class="admin-card-body" style="display:flex;flex-direction:column;gap:10px">
            <a href="{{ route('admin.products.create') }}" class="btn-admin btn-admin-outline" style="justify-content:flex-start">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                Create New Product
            </a>
            <a href="{{ route('admin.categories.create') }}" class="btn-admin btn-admin-outline" style="justify-content:flex-start">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                Add Category
            </a>
            <a href="{{ route('admin.projects.create') }}" class="btn-admin btn-admin-outline" style="justify-content:flex-start">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Add Portfolio Project
            </a>
            <a href="{{ route('admin.settings.index') }}" class="btn-admin btn-admin-outline" style="justify-content:flex-start">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
                Manage Website Settings
            </a>
            <a href="{{ route('admin.enquiries.index') }}" class="btn-admin btn-admin-primary" style="justify-content:center;margin-top:6px">
                Open Full CRM Inbox
            </a>
        </div>
    </div>
</div>

<!-- Recent Inquiries Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h2 class="admin-card-title">Recent Client Enquiries</h2>
            <p style="font-size:0.75rem;color:var(--admin-muted);margin-top:2px">Latest quote requests from prospective customers</p>
        </div>
        <a href="{{ route('admin.enquiries.index') }}" class="btn-admin btn-admin-outline btn-admin-sm">View All Enquiries</a>
    </div>
    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Ref #</th>
                    <th>Customer Name</th>
                    <th>Mobile / Contact</th>
                    <th>Product / Category</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th style="text-align:right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentEnquiries as $enquiry)
                <tr>
                    <td>
                        <span style="font-family:'Outfit',sans-serif;font-weight:700;color:var(--admin-gold);font-size:0.8rem">
                            {{ $enquiry->reference_number }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight:600">{{ $enquiry->full_name }}</div>
                        @if($enquiry->company_name)
                            <div style="font-size:0.75rem;color:var(--admin-muted)">{{ $enquiry->company_name }}</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-size:0.85rem">{{ $enquiry->mobile_number }}</div>
                        <div style="font-size:0.75rem;color:var(--admin-muted)">{{ $enquiry->email }}</div>
                    </td>
                    <td>
                        <div>{{ $enquiry->product_name ?? optional($enquiry->product)->name ?? 'General Request' }}</div>
                        <div style="font-size:0.75rem;color:var(--admin-gold)">{{ optional($enquiry->category)->name ?? '—' }}</div>
                    </td>
                    <td style="font-size:0.8rem;color:var(--admin-muted)">
                        {{ $enquiry->created_at->format('d M Y, h:i A') }}
                    </td>
                    <td>
                        <span class="badge-status badge-{{ $enquiry->status }}">
                            {{ $enquiry->status_label }}
                        </span>
                    </td>
                    <td style="text-align:right">
                        <a href="{{ route('admin.enquiries.show', $enquiry->id) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                            View Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;color:var(--admin-muted)">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 10px;display:block;opacity:0.4"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        No enquiries received yet. Submissions from the website will appear here in real-time.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
