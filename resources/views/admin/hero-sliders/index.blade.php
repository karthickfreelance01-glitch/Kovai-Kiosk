@extends('layouts.admin')
@section('title', 'Hero Slider Management')
@section('page-title', 'Hero Slider Management')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Homepage Hero Sliders</h1>
        <p class="page-head-sub">Manage the animated 3D product showcase on the homepage hero section.</p>
    </div>
    <a href="{{ route('admin.hero-sliders.create') }}" class="btn-admin btn-admin-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add New Slide
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header" style="display:flex;align-items:center;justify-content:space-between">
        <div>
            <h2 class="admin-card-title">All Hero Slides ({{ $sliders->total() }})</h2>
            <span style="font-size:0.75rem;color:var(--admin-muted)">Only active slides are displayed on the public homepage, sorted by display order.</span>
        </div>
        <div style="font-size:0.75rem;color:var(--admin-gold);display:flex;align-items:center;gap:6px">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            Supported categories: Smart Kiosk, Push Cart, EV Vehicles
        </div>
    </div>

    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:90px">Slide Image</th>
                    <th>Title & Subtitle</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Button / Link</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sliders as $slider)
                <tr>
                    <td>
                        <div style="position:relative;width:76px;height:52px;border-radius:8px;overflow:hidden;border:1px solid var(--admin-border);background:#12141c">
                            @if($slider->image_url)
                                <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" style="width:100%;height:100%;object-fit:cover" onerror="this.onerror=null;this.parentElement.innerHTML='<div style=\'display:flex;align-items:center;justify-content:center;height:100%;color:var(--admin-muted);font-size:10px\'>No Image</div>'">
                            @else
                                <div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--admin-muted);font-size:10px">
                                    No Image
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:0.92rem;color:var(--admin-text)">
                            {{ $slider->title }}
                        </div>
                        @if($slider->subtitle)
                            <div style="font-size:0.78rem;color:var(--admin-gold);margin-top:2px">
                                {{ $slider->subtitle }}
                            </div>
                        @endif
                    </td>
                    <td>
                        @php
                            $catColors = [
                                'Smart Kiosk' => ['bg' => 'rgba(59,130,246,0.15)', 'color' => '#93C5FD'],
                                'Push Cart'   => ['bg' => 'rgba(245,158,11,0.15)', 'color' => '#FCD34D'],
                                'EV Vehicles' => ['bg' => 'rgba(16,185,129,0.15)', 'color' => '#6EE7B7'],
                            ];
                            $style = $catColors[$slider->category] ?? ['bg' => 'rgba(255,255,255,0.08)', 'color' => 'var(--admin-text)'];
                        @endphp
                        @if($slider->category)
                            <span class="badge-status" style="background:{{ $style['bg'] }};color:{{ $style['color'] }};border:1px solid rgba(255,255,255,0.05)">
                                {{ $slider->category }}
                            </span>
                        @else
                            <span style="color:var(--admin-muted);font-size:0.75rem">—</span>
                        @endif
                    </td>
                    <td>
                        @if($slider->description)
                            <div style="font-size:0.78rem;color:var(--admin-muted);max-width:240px;line-height:1.4" title="{{ $slider->description }}">
                                {{ Str::limit($slider->description, 80) }}
                            </div>
                        @else
                            <span style="color:var(--admin-muted);font-size:0.75rem">—</span>
                        @endif
                    </td>
                    <td>
                        @if($slider->button_text)
                            <div style="font-size:0.8rem;font-weight:500;color:var(--admin-text)">
                                {{ $slider->button_text }}
                            </div>
                            @if($slider->button_url)
                                <a href="{{ $slider->button_url }}" target="_blank" style="font-size:0.72rem;color:var(--admin-blue);text-decoration:underline">
                                    {{ Str::limit($slider->button_url, 22) }}
                                </a>
                            @endif
                        @else
                            <span style="color:var(--admin-muted);font-size:0.75rem">—</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-weight:700;color:var(--admin-gold);background:rgba(201,168,76,0.1);padding:3px 8px;border-radius:4px;font-size:0.82rem">
                            #{{ $slider->display_order }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.hero-sliders.toggle-status', $slider->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" title="Click to toggle status" style="background:none;border:none;cursor:pointer;padding:0">
                                @if($slider->is_active)
                                    <span class="badge-status badge-active" style="cursor:pointer">● Active</span>
                                @else
                                    <span class="badge-status badge-inactive" style="cursor:pointer">○ Inactive</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td>
                        <span style="font-size:0.78rem;color:var(--admin-muted)">
                            {{ $slider->created_at ? $slider->created_at->format('d M Y') : '—' }}
                        </span>
                    </td>
                    <td style="text-align:right">
                        <div style="display:inline-flex;gap:6px">
                            <a href="{{ route('admin.hero-sliders.edit', $slider->id) }}" class="btn-admin btn-admin-outline btn-admin-sm" title="Edit Slide">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.hero-sliders.destroy', $slider->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this hero slide? This action cannot be undone and its image will be removed.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin btn-admin-danger btn-admin-sm" title="Delete Slide">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:48px 20px">
                        <div style="width:64px;height:64px;margin:0 auto 16px;border-radius:50%;background:rgba(201,168,76,0.1);display:flex;align-items:center;justify-content:center;color:var(--admin-gold)">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><polygon points="10 8 16 11 10 14 10 8"/></svg>
                        </div>
                        <h3 style="font-family:'Outfit',sans-serif;font-size:1.1rem;font-weight:600;margin-bottom:6px">No Hero Slides Found</h3>
                        <p style="font-size:0.85rem;color:var(--admin-muted);max-width:440px;margin:0 auto 20px">
                            Get started by creating your first animated product slide. Add high-quality kiosk or cart visuals to showcase on the homepage hero section.
                        </p>
                        <a href="{{ route('admin.hero-sliders.create') }}" class="btn-admin btn-admin-primary">
                            + Add Your First Slide
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($sliders->hasPages())
    <div style="padding:16px 24px;border-top:1px solid var(--admin-border)">
        {{ $sliders->links() }}
    </div>
    @endif
</div>
@endsection

