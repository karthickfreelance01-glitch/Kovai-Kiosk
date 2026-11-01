<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | Kovai Kiosk</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
    :root {
        --admin-bg: #0F1117;
        --admin-sidebar: #161820;
        --admin-card: #1E2028;
        --admin-card-hover: #252830;
        --admin-border: rgba(255,255,255,0.07);
        --admin-text: #E8E9F0;
        --admin-muted: #6B7280;
        --admin-gold: #C9A84C;
        --admin-gold-light: #E8C96D;
        --admin-blue: #3B82F6;
        --admin-green: #10B981;
        --admin-red: #EF4444;
        --admin-yellow: #F59E0B;
        --admin-purple: #8B5CF6;
        --sidebar-width: 260px;
        --header-height: 64px;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; font-family: 'Inter', sans-serif; background: var(--admin-bg); color: var(--admin-text); }
    a { text-decoration: none; color: inherit; }
    img { max-width: 100%; }

    /* Layout */
    .admin-layout { display: flex; min-height: 100vh; }

    /* Sidebar */
    .admin-sidebar {
        width: var(--sidebar-width); background: var(--admin-sidebar);
        border-right: 1px solid var(--admin-border);
        position: fixed; top: 0; left: 0; bottom: 0;
        z-index: 100; overflow-y: auto;
        transition: transform 0.3s ease;
        display: flex; flex-direction: column;
    }
    .sidebar-header {
        padding: 24px 20px;
        border-bottom: 1px solid var(--admin-border);
        flex-shrink: 0;
    }
    .sidebar-logo {
        display: flex; align-items: center; gap: 12px;
    }
    .sidebar-logo-icon {
        width: 38px; height: 38px;
        background: linear-gradient(135deg, var(--admin-gold), #9E7B2E);
        border-radius: 8px; display: flex; align-items: center; justify-content: center;
    }
    .sidebar-logo-text { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; }
    .sidebar-logo-sub { font-size: 0.65rem; color: var(--admin-muted); letter-spacing: 1.5px; text-transform: uppercase; }

    .sidebar-nav { padding: 16px 12px; flex: 1; overflow-y: auto; }
    .nav-section-label {
        font-size: 0.65rem; font-weight: 700; letter-spacing: 2.5px;
        text-transform: uppercase; color: var(--admin-muted);
        padding: 12px 8px 6px; margin-top: 8px;
    }
    .sidebar-link {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 12px; border-radius: 8px;
        font-family: 'Outfit', sans-serif; font-size: 0.875rem; font-weight: 500;
        color: var(--admin-muted); transition: all 0.2s; margin-bottom: 2px;
    }
    .sidebar-link svg { width: 18px; height: 18px; flex-shrink: 0; }
    .sidebar-link:hover { background: rgba(255,255,255,0.05); color: var(--admin-text); }
    .sidebar-link.active { background: rgba(201,168,76,0.12); color: var(--admin-gold); border: 1px solid rgba(201,168,76,0.2); }
    .sidebar-link .badge {
        margin-left: auto; background: var(--admin-red);
        color: white; font-size: 0.65rem; font-weight: 700;
        padding: 2px 6px; border-radius: 10px; min-width: 18px; text-align: center;
    }

    .sidebar-footer {
        padding: 16px 12px;
        border-top: 1px solid var(--admin-border);
        flex-shrink: 0;
    }
    .sidebar-user {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 12px; border-radius: 8px;
        background: rgba(255,255,255,0.03);
    }
    .sidebar-user-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, var(--admin-gold), #9E7B2E);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.875rem; flex-shrink: 0;
    }
    .sidebar-user-name { font-size: 0.85rem; font-weight: 600; }
    .sidebar-user-role { font-size: 0.7rem; color: var(--admin-muted); }

    /* Main Content */
    .admin-main {
        margin-left: var(--sidebar-width);
        flex: 1; display: flex; flex-direction: column; min-height: 100vh;
    }

    /* Top Header */
    .admin-header {
        height: var(--header-height);
        background: var(--admin-sidebar);
        border-bottom: 1px solid var(--admin-border);
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 28px;
        position: sticky; top: 0; z-index: 50;
    }
    .admin-header-title { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 600; }
    .admin-header-actions { display: flex; align-items: center; gap: 16px; }
    .admin-header-link {
        display: flex; align-items: center; gap: 6px;
        font-size: 0.82rem; color: var(--admin-muted);
        padding: 6px 12px; border-radius: 6px;
        border: 1px solid var(--admin-border);
        transition: all 0.2s;
    }
    .admin-header-link:hover { color: var(--admin-text); border-color: rgba(255,255,255,0.15); }
    .logout-form { display: inline; }
    .logout-btn {
        display: flex; align-items: center; gap: 6px;
        font-size: 0.82rem; color: var(--admin-red);
        padding: 6px 12px; border-radius: 6px;
        border: 1px solid rgba(239,68,68,0.2);
        background: none; cursor: pointer; font-family: 'Inter', sans-serif;
        transition: all 0.2s;
    }
    .logout-btn:hover { background: rgba(239,68,68,0.1); }

    /* Page Content */
    .admin-content { padding: 28px; flex: 1; }

    /* Cards */
    .admin-card {
        background: var(--admin-card);
        border: 1px solid var(--admin-border);
        border-radius: 12px;
    }
    .admin-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--admin-border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .admin-card-title { font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 700; }
    .admin-card-body { padding: 24px; }

    /* Stats Cards */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    .stat-card {
        background: var(--admin-card); border: 1px solid var(--admin-border);
        border-radius: 12px; padding: 20px 24px;
        display: flex; align-items: center; gap: 16px;
        transition: border-color 0.2s;
    }
    .stat-card:hover { border-color: rgba(255,255,255,0.12); }
    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-num { font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 700; line-height: 1; }
    .stat-label { font-size: 0.78rem; color: var(--admin-muted); margin-top: 4px; }

    /* Buttons */
    .btn-admin {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 8px 16px; border-radius: 8px;
        font-family: 'Outfit', sans-serif; font-size: 0.83rem; font-weight: 600;
        transition: all 0.2s; cursor: pointer; border: 1px solid transparent;
    }
    .btn-admin-primary { background: var(--admin-gold); color: #000; border-color: var(--admin-gold); }
    .btn-admin-primary:hover { background: var(--admin-gold-light); }
    .btn-admin-sm { padding: 5px 12px; font-size: 0.78rem; }
    .btn-admin-outline { border-color: var(--admin-border); color: var(--admin-text); }
    .btn-admin-outline:hover { border-color: rgba(255,255,255,0.2); background: rgba(255,255,255,0.04); }
    .btn-admin-danger { border-color: rgba(239,68,68,0.3); color: var(--admin-red); }
    .btn-admin-danger:hover { background: rgba(239,68,68,0.1); }
    .btn-admin-success { background: var(--admin-green); color: white; border-color: var(--admin-green); }
    .btn-admin-success:hover { background: #0da371; }

    /* Table */
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th {
        text-align: left; padding: 12px 16px;
        font-size: 0.72rem; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: var(--admin-muted);
        border-bottom: 1px solid var(--admin-border);
    }
    .admin-table td {
        padding: 14px 16px; border-bottom: 1px solid var(--admin-border);
        font-size: 0.85rem; vertical-align: middle;
    }
    .admin-table tr:last-child td { border-bottom: none; }
    .admin-table tbody tr:hover td { background: rgba(255,255,255,0.02); }

    /* Status Badges */
    .badge-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 700; font-family: 'Outfit', sans-serif;
    }
    .badge-new { background: rgba(59,130,246,0.15); color: #60A5FA; }
    .badge-contacted { background: rgba(245,158,11,0.15); color: #FCD34D; }
    .badge-follow_up { background: rgba(249,115,22,0.15); color: #FB923C; }
    .badge-quotation_sent { background: rgba(139,92,246,0.15); color: #A78BFA; }
    .badge-converted { background: rgba(16,185,129,0.15); color: #34D399; }
    .badge-closed { background: rgba(107,114,128,0.15); color: #9CA3AF; }
    .badge-active { background: rgba(16,185,129,0.15); color: #34D399; }
    .badge-inactive { background: rgba(239,68,68,0.15); color: #FCA5A5; }

    /* Form Controls */
    .admin-form-group { margin-bottom: 20px; }
    .admin-form-label {
        display: block; margin-bottom: 6px;
        font-size: 0.8rem; font-weight: 600; color: var(--admin-muted);
        font-family: 'Outfit', sans-serif; letter-spacing: 0.5px;
    }
    .admin-form-control {
        width: 100%; padding: 10px 14px;
        background: var(--admin-bg); border: 1px solid var(--admin-border);
        border-radius: 8px; color: var(--admin-text);
        font-family: 'Inter', sans-serif; font-size: 0.88rem;
        transition: border-color 0.2s; outline: none;
    }
    .admin-form-control:focus { border-color: var(--admin-gold); }
    .admin-form-control::placeholder { color: var(--admin-muted); }
    textarea.admin-form-control { resize: vertical; min-height: 100px; }
    select.admin-form-control { cursor: pointer; appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-repeat: no-repeat; background-position: right 10px center; background-size: 14px;
    }
    .admin-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .admin-form-error { color: var(--admin-red); font-size: 0.75rem; margin-top: 4px; }

    /* Flash */
    .admin-flash {
        padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 10px;
        font-size: 0.875rem;
    }
    .admin-flash-success { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.3); color: #6EE7B7; }
    .admin-flash-error { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.3); color: #FCA5A5; }

    /* Pagination */
    .admin-pagination { display: flex; gap: 8px; align-items: center; margin-top: 20px; justify-content: center; flex-wrap: wrap; }
    .admin-pagination a, .admin-pagination span {
        padding: 6px 12px; border-radius: 6px; font-size: 0.82rem; font-family: 'Outfit', sans-serif;
        border: 1px solid var(--admin-border); color: var(--admin-muted);
    }
    .admin-pagination a:hover { border-color: var(--admin-gold); color: var(--admin-gold); }
    .admin-pagination .active { background: var(--admin-gold); color: #000; border-color: var(--admin-gold); }

    /* Toggle Switch */
    .toggle-switch { position: relative; display: inline-flex; align-items: center; cursor: pointer; }
    .toggle-switch input { display: none; }
    .toggle-slider {
        width: 40px; height: 22px; background: rgba(255,255,255,0.1);
        border-radius: 11px; transition: 0.3s; position: relative;
    }
    .toggle-slider::after {
        content: ''; position: absolute; width: 16px; height: 16px;
        background: white; border-radius: 50%; top: 3px; left: 3px; transition: 0.3s;
    }
    .toggle-switch input:checked + .toggle-slider { background: var(--admin-green); }
    .toggle-switch input:checked + .toggle-slider::after { transform: translateX(18px); }

    /* Page Header */
    .page-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 24px;
    }
    .page-head-title { font-family: 'Outfit', sans-serif; font-size: 1.4rem; font-weight: 700; }
    .page-head-sub { color: var(--admin-muted); font-size: 0.82rem; margin-top: 2px; }

    /* Search/Filter Bar */
    .filter-bar {
        display: flex; gap: 12px; flex-wrap: wrap;
        background: var(--admin-card); border: 1px solid var(--admin-border);
        border-radius: 10px; padding: 16px 20px; margin-bottom: 20px;
        align-items: flex-end;
    }
    .filter-bar .admin-form-group { margin: 0; flex: 1; min-width: 160px; }

    /* Image Uploader */
    .img-upload-area {
        border: 2px dashed var(--admin-border); border-radius: 10px;
        padding: 32px; text-align: center; cursor: pointer;
        transition: border-color 0.2s;
    }
    .img-upload-area:hover { border-color: var(--admin-gold); }

    /* Mobile */
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .admin-sidebar { transform: translateX(-100%); }
        .admin-sidebar.open { transform: translateX(0); }
        .admin-main { margin-left: 0; }
        .stats-grid { grid-template-columns: 1fr 1fr; }
        .admin-form-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        .admin-content { padding: 16px; }
    }
    </style>
    @yield('styles')
</head>
<body>
<div class="admin-layout">

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="admin-sidebar" role="navigation" aria-label="Admin Navigation">
        <!-- Logo -->
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <div class="sidebar-logo-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </div>
                <div>
                    <div class="sidebar-logo-text">Kovai Kiosk</div>
                    <div class="sidebar-logo-sub">Admin Panel</div>
                </div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="sidebar-nav">
            <div class="nav-section-label">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>

            <div class="nav-section-label">Catalogue</div>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
                Categories
            </a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                Products
            </a>
            <a href="{{ route('admin.projects.index') }}" class="sidebar-link {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Projects
            </a>

            <div class="nav-section-label">CRM</div>
            <a href="{{ route('admin.enquiries.index') }}" class="sidebar-link {{ request()->routeIs('admin.enquiries*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Enquiries
                @php $newCount = \App\Models\Enquiry::where('status','new')->count(); @endphp
                @if($newCount > 0)<span class="badge">{{ $newCount }}</span>@endif
            </a>

            <div class="nav-section-label">Website Management</div>
            <a href="{{ route('admin.hero-sliders.index') }}" class="sidebar-link {{ request()->routeIs('admin.hero-sliders*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/><polygon points="10 8 16 10.5 10 13 10 8" fill="currentColor"/></svg>
                Hero Slider Management
            </a>
            <a href="{{ route('admin.about-showcase.index') }}" class="sidebar-link {{ request()->routeIs('admin.about-showcase*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><line x1="7" y1="15" x2="7.01" y2="15"/><line x1="12" y1="15" x2="12.01" y2="15"/><line x1="17" y1="15" x2="17.01" y2="15"/><polyline points="7 10 12 7 17 10"/></svg>
                About Showcase (Query Loop)
            </a>

            <div class="nav-section-label">Config</div>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
                Site Settings
            </a>
            <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                View Website
            </a>
        </nav>

        <!-- User -->
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div>
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">Administrator</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <div class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div style="display:flex;align-items:center;gap:16px">
                <button id="sidebar-toggle" style="display:none;background:none;border:none;cursor:pointer;padding:4px" aria-label="Toggle sidebar">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--admin-text)" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div class="admin-header-title">@yield('page-title', 'Dashboard')</div>
            </div>
            <div class="admin-header-actions">
                <a href="{{ route('home') }}" class="admin-header-link" target="_blank">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/></svg>
                    Website
                </a>
                <form class="logout-form" action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Content -->
        <main class="admin-content" role="main">
            @if(session('success'))
            <div class="admin-flash admin-flash-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="admin-flash admin-flash-error">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<script>
// Mobile sidebar toggle
const sidebarToggle = document.getElementById('sidebar-toggle');
const sidebar = document.getElementById('admin-sidebar');
if (sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });
}

// Auto-hide flash messages
setTimeout(() => {
    document.querySelectorAll('.admin-flash').forEach(el => {
        el.style.transition = 'opacity 0.4s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 400);
    });
}, 4000);

// Confirm delete
document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', function(e) {
        if (!confirm(this.dataset.confirm || 'Are you sure?')) {
            e.preventDefault();
        }
    });
});

// Responsive: show toggle on small screens
function checkSidebar() {
    sidebarToggle.style.display = window.innerWidth <= 768 ? 'block' : 'none';
}
checkSidebar();
window.addEventListener('resize', checkSidebar);
</script>
@yield('scripts')
</body>
</html>
