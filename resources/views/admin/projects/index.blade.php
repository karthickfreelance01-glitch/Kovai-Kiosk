@extends('layouts.admin')
@section('title', 'Projects')
@section('page-title', 'Portfolio & Projects')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Manufacturing Projects & Portfolio</h1>
        <p class="page-head-sub">Showcase completed kiosk installations, mall cart setups, and fleet deployments.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn-admin btn-admin-primary">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add New Project
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h2 class="admin-card-title">Completed Installations ({{ $projects->total() }})</h2>
        <span style="font-size:0.75rem;color:var(--admin-muted)">Client proof and manufacturing portfolio</span>
    </div>
    <div style="overflow-x:auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:70px">Photo</th>
                    <th>Project Title</th>
                    <th>Category</th>
                    <th>Client Name</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr>
                    <td>
                        <div style="width:52px;height:44px;border-radius:6px;overflow:hidden;border:1px solid var(--admin-border);background:rgba(255,255,255,0.04);display:flex;align-items:center;justify-content:center">
                            @if($project->has_image)
                                <img src="{{ $project->primary_image_url }}" alt="{{ $project->title }}" style="width:100%;height:100%;object-fit:cover" onerror="this.style.display='none';if(this.nextElementSibling){this.nextElementSibling.style.display='block';}">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--admin-muted);display:none"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                            @else
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--admin-muted)"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:0.92rem">{{ $project->title }}</div>
                        @if($project->completed_date)
                            <div style="font-size:0.75rem;color:var(--admin-muted)">Completed: {{ \Carbon\Carbon::parse($project->completed_date)->format('M Y') }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="badge-status" style="background:rgba(201,168,76,0.12);color:var(--admin-gold)">
                            {{ optional($project->category)->name ?? 'General' }}
                        </span>
                    </td>
                    <td>
                        <div style="font-size:0.85rem">{{ $project->client_name ?? 'Confidential' }}</div>
                    </td>
                    <td>
                        <div style="font-size:0.85rem">{{ $project->location ?? 'Tamil Nadu' }}</div>
                    </td>
                    <td>
                        @if($project->is_active)
                            <span class="badge-status badge-active">Published</span>
                        @else
                            <span class="badge-status badge-inactive">Draft</span>
                        @endif
                    </td>
                    <td style="text-align:right">
                        <div style="display:inline-flex;gap:6px">
                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn-admin btn-admin-outline btn-admin-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete this project?')">
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
                    <td colspan="7" style="text-align:center;padding:40px;color:var(--admin-muted)">
                        No portfolio projects added yet. Click "Add New Project" to showcase installations.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($projects->hasPages())
    <div style="padding:20px;border-top:1px solid var(--admin-border)">
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection
