<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', $siteSettings['meta_title'] ?? 'Kovai Kiosk | Premium Kiosk Manufacturers')</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Leading manufacturer of smart kiosks, push carts and EV vehicles.')">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', $siteSettings['meta_title'] ?? 'Kovai Kiosk')">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['meta_description'] ?? '')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Favicon -->
    @if(!empty($siteSettings['favicon']))
        <link rel="icon" href="{{ asset('storage/' . $siteSettings['favicon']) }}">
    @else
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    
    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <style>
        /* ===========================
           CSS CUSTOM PROPERTIES
        =========================== */
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C96D;
            --gold-dark: #9E7B2E;
            --ivory: #FAF8F4;
            --ivory-dark: #F0EDE6;
            --charcoal: #1C1C1E;
            --charcoal-light: #2C2C2E;
            --navy: #0D1B2A;
            --navy-light: #1A2E45;
            --text-primary: #1C1C1E;
            --text-secondary: #4A4A4A;
            --text-muted: #7A7A7A;
            --white: #FFFFFF;
            --border: #E8E5DF;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
            --shadow-md: 0 8px 32px rgba(0,0,0,0.10);
            --shadow-lg: 0 20px 60px rgba(0,0,0,0.14);
            --shadow-gold: 0 8px 32px rgba(201,168,76,0.25);
            --radius: 12px;
            --radius-lg: 20px;
            --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===========================
           RESET & BASE
        =========================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; font-size: 16px; }
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: var(--white);
            line-height: 1.7;
            overflow-x: hidden;
        }
        img { max-width: 100%; height: auto; display: block; }
        a { text-decoration: none; color: inherit; }
        ul, ol { list-style: none; }
        button { cursor: pointer; border: none; background: none; font-family: inherit; }

        /* ===========================
           TYPOGRAPHY
        =========================== */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            line-height: 1.2;
            color: var(--text-primary);
        }
        .font-inter { font-family: 'Inter', sans-serif; }
        .font-outfit { font-family: 'Outfit', sans-serif; }

        /* ===========================
           UTILITY CLASSES
        =========================== */
        .container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
        .container-narrow { max-width: 900px; margin: 0 auto; padding: 0 24px; }
        .section-pad { padding: 100px 0; }
        .section-pad-sm { padding: 60px 0; }
        .text-gold { color: var(--gold); }
        .text-center { text-align: center; }
        .flex { display: flex; }
        .flex-center { display: flex; align-items: center; justify-content: center; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 32px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }

        .section-label {
            display: inline-flex; align-items: center; gap: 10px;
            font-family: 'Outfit', sans-serif; font-size: 12px;
            font-weight: 600; letter-spacing: 3px; text-transform: uppercase;
            color: var(--gold); margin-bottom: 16px;
        }
        .section-label::before, .section-label::after {
            content: ''; width: 30px; height: 1px; background: var(--gold);
        }
        .section-title {
            font-size: clamp(2rem, 4vw, 3.2rem);
            font-weight: 700; margin-bottom: 20px;
        }
        .section-subtitle {
            font-size: 1.1rem; color: var(--text-secondary);
            max-width: 600px; margin: 0 auto 60px;
        }

        /* ===========================
           BUTTONS
        =========================== */
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 14px 32px; border-radius: 50px;
            font-family: 'Outfit', sans-serif; font-weight: 600;
            font-size: 0.95rem; letter-spacing: 0.5px;
            transition: var(--transition); cursor: pointer;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            box-shadow: var(--shadow-gold);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(201,168,76,0.4);
            color: var(--white);
        }
        .btn-outline {
            border: 2px solid var(--gold);
            color: var(--gold);
            background: transparent;
        }
        .btn-outline:hover {
            background: var(--gold);
            color: var(--white);
            transform: translateY(-3px);
        }
        .btn-outline-white {
            border: 2px solid rgba(255,255,255,0.6);
            color: var(--white);
        }
        .btn-outline-white:hover {
            background: var(--white);
            color: var(--text-primary);
            border-color: var(--white);
        }
        .btn-dark {
            background: var(--charcoal);
            color: var(--white);
        }
        .btn-dark:hover {
            background: var(--charcoal-light);
            transform: translateY(-3px);
            color: var(--white);
        }
        .btn-sm { padding: 10px 22px; font-size: 0.875rem; }

        /* ===========================
           ANNOUNCEMENT BAR
        =========================== */
        .announcement-bar {
            background: linear-gradient(90deg, var(--charcoal), var(--navy), var(--charcoal));
            color: var(--white);
            text-align: center;
            padding: 10px 20px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1001;
        }
        .announcement-bar span { color: var(--gold-light); font-weight: 600; }

        /* ===========================
           HEADER / NAVBAR
        =========================== */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            transition: var(--transition);
        }
        .header.scrolled {
            box-shadow: var(--shadow-md);
        }
        .header-inner {
            display: flex; align-items: center;
            justify-content: space-between;
            height: 76px;
        }
        .logo {
            display: flex; align-items: center; gap: 12px;
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; font-weight: 700;
            color: var(--charcoal);
        }
        .logo-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-img { height: 44px; width: auto; object-fit: contain; }
        .logo-text { line-height: 1.1; }
        .logo-text small {
            display: block; font-family: 'Outfit', sans-serif;
            font-size: 0.65rem; font-weight: 500;
            letter-spacing: 2px; text-transform: uppercase;
            color: var(--gold); margin-top: 2px;
        }

        /* Nav */
        .nav { display: flex; align-items: center; gap: 4px; }
        .nav-item { position: relative; }
        .nav-link {
            display: flex; align-items: center; gap: 4px;
            padding: 10px 16px; border-radius: 8px;
            font-family: 'Outfit', sans-serif; font-size: 0.9rem;
            font-weight: 500; color: var(--text-secondary);
            transition: var(--transition);
        }
        .nav-link:hover, .nav-link.active {
            color: var(--gold); background: rgba(201,168,76,0.08);
        }
        .nav-link svg { width: 14px; height: 14px; transition: transform 0.2s; }
        .nav-item:hover .nav-link svg { transform: rotate(180deg); }

        /* Dropdown */
        .nav-dropdown {
            position: absolute; top: calc(100% + 8px); left: 0;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            min-width: 240px;
            opacity: 0; visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 999;
        }
        .nav-item:hover .nav-dropdown {
            opacity: 1; visibility: visible; transform: translateY(0);
        }
        .nav-dropdown-inner { padding: 8px; }
        .nav-dropdown-link {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px; border-radius: 8px;
            font-family: 'Outfit', sans-serif; font-size: 0.88rem;
            font-weight: 500; color: var(--text-secondary);
            transition: var(--transition);
        }
        .nav-dropdown-link:hover {
            background: rgba(201,168,76,0.08); color: var(--gold);
        }
        .nav-dropdown-link .cat-icon {
            width: 32px; height: 32px;
            background: var(--ivory-dark);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .dropdown-divider {
            height: 1px; background: var(--border);
            margin: 4px 16px;
        }
        .dropdown-view-all {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            padding: 12px;
            font-size: 0.82rem; font-weight: 600; color: var(--gold);
            font-family: 'Outfit', sans-serif;
        }

        /* Header CTA */
        .header-actions { display: flex; align-items: center; gap: 12px; }
        .header-phone {
            display: flex; align-items: center; gap: 8px;
            font-family: 'Outfit', sans-serif; font-size: 0.85rem;
            font-weight: 600; color: var(--text-secondary);
        }
        .header-phone a { color: var(--text-primary); transition: color 0.2s; }
        .header-phone a:hover { color: var(--gold); }

        /* Mobile Menu Toggle */
        .mobile-toggle {
            display: none;
            flex-direction: column; gap: 5px;
            width: 30px; cursor: pointer; padding: 5px;
        }
        .mobile-toggle span {
            display: block; height: 2px; width: 100%;
            background: var(--charcoal);
            transition: var(--transition);
            border-radius: 2px;
        }
        .mobile-toggle.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
        .mobile-toggle.active span:nth-child(2) { opacity: 0; }
        .mobile-toggle.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

        /* Mobile Nav */
        .mobile-nav {
            display: none;
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: var(--white); z-index: 999;
            padding: 90px 24px 40px;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-nav.open { transform: translateX(0); display: block; }
        .mobile-nav-link {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 0; border-bottom: 1px solid var(--border);
            font-family: 'Outfit', sans-serif; font-size: 1.1rem;
            font-weight: 500; color: var(--text-primary);
        }
        .mobile-nav-link:hover { color: var(--gold); }
        .mobile-nav-sub { padding: 8px 0 8px 20px; }
        .mobile-nav-sub a {
            display: block; padding: 10px 0;
            font-family: 'Outfit', sans-serif; font-size: 0.95rem;
            color: var(--text-secondary); border-bottom: 1px solid var(--border);
        }
        .mobile-nav-sub a:hover { color: var(--gold); }

        /* ===========================
           CARDS
        =========================== */
        .card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: var(--transition);
        }
        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(201,168,76,0.3);
        }

        /* ===========================
           PRODUCT CARD
        =========================== */
        .product-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: var(--transition);
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 24px 64px rgba(0,0,0,0.12);
            border-color: rgba(201,168,76,0.4);
        }
        .product-card-image {
            position: relative; aspect-ratio: 4/3; overflow: hidden;
            background: var(--ivory-dark);
        }
        .product-card-image img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover .product-card-image img { transform: scale(1.08); }
        .product-card-badge {
            position: absolute; top: 16px; left: 16px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white); padding: 4px 12px;
            border-radius: 20px; font-size: 0.75rem;
            font-family: 'Outfit', sans-serif; font-weight: 600;
            letter-spacing: 0.5px;
        }
        .product-card-actions {
            position: absolute; bottom: -60px; left: 0; right: 0;
            display: flex; gap: 8px; padding: 16px;
            transition: bottom 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover .product-card-actions { bottom: 0; }
        .product-card-actions .btn { flex: 1; justify-content: center; font-size: 0.82rem; padding: 10px; }
        .product-card-body { padding: 24px; }
        .product-card-cat {
            font-family: 'Outfit', sans-serif; font-size: 0.75rem;
            font-weight: 600; letter-spacing: 2px; text-transform: uppercase;
            color: var(--gold); margin-bottom: 8px;
        }
        .product-card-title {
            font-size: 1.2rem; font-weight: 700; margin-bottom: 10px;
        }
        .product-card-desc {
            font-size: 0.88rem; color: var(--text-muted);
            line-height: 1.6; margin-bottom: 16px;
            display: -webkit-box; -webkit-line-clamp: 3;
            -webkit-box-orient: vertical; overflow: hidden;
        }

        /* ===========================
           FOOTER
        =========================== */
        .footer {
            background: linear-gradient(160deg, var(--charcoal) 0%, var(--navy) 100%);
            color: rgba(255,255,255,0.75);
        }
        .footer-top { padding: 80px 0 60px; }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 60px;
        }
        .footer-logo-area { margin-bottom: 20px; }
        .footer-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem; font-weight: 700;
            color: var(--white); margin-bottom: 16px;
        }
        .footer-desc {
            font-size: 0.9rem; line-height: 1.8; color: rgba(255,255,255,0.6);
            margin-bottom: 24px;
        }
        .footer-social { display: flex; gap: 12px; }
        .footer-social a {
            width: 38px; height: 38px;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.6);
            transition: var(--transition);
        }
        .footer-social a:hover {
            background: var(--gold); border-color: var(--gold); color: var(--white);
        }
        .footer-col-title {
            font-family: 'Outfit', sans-serif; font-size: 0.8rem;
            font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase;
            color: var(--gold); margin-bottom: 24px;
        }
        .footer-links { display: flex; flex-direction: column; gap: 12px; }
        .footer-links a {
            font-size: 0.88rem; color: rgba(255,255,255,0.6);
            transition: color 0.2s;
        }
        .footer-links a:hover { color: var(--gold-light); }
        .footer-contact-item {
            display: flex; gap: 14px;
            font-size: 0.88rem; color: rgba(255,255,255,0.6);
            margin-bottom: 16px;
        }
        .footer-contact-item svg { flex-shrink: 0; color: var(--gold); margin-top: 2px; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 24px 0;
        }
        .footer-bottom-inner {
            display: flex; align-items: center;
            justify-content: space-between;
            flex-wrap: wrap; gap: 16px;
        }
        .footer-copyright {
            font-size: 0.83rem; color: rgba(255,255,255,0.4);
        }

        /* ===========================
           PAGE HERO (inner pages)
        =========================== */
        .page-hero {
            background: linear-gradient(135deg, var(--navy) 0%, var(--charcoal) 100%);
            padding: 80px 0;
            position: relative; overflow: hidden;
        }
        .page-hero::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C9A84C' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .page-hero-content { position: relative; z-index: 1; }
        .breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-family: 'Outfit', sans-serif; font-size: 0.85rem;
            color: rgba(255,255,255,0.5); margin-bottom: 20px;
        }
        .breadcrumb a { color: var(--gold-light); }
        .breadcrumb a:hover { color: var(--gold); }
        .breadcrumb-sep { color: rgba(255,255,255,0.3); }
        .page-hero h1 { color: var(--white); font-size: clamp(2rem, 5vw, 3.5rem); margin-bottom: 16px; }
        .page-hero p { color: rgba(255,255,255,0.65); font-size: 1.1rem; max-width: 600px; }

        /* ===========================
           FLASH MESSAGES
        =========================== */
        .flash-message {
            padding: 16px 24px;
            border-radius: var(--radius);
            margin: 16px 0;
            font-family: 'Outfit', sans-serif;
            font-size: 0.9rem;
            display: flex; align-items: center; gap: 10px;
        }
        .flash-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .flash-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .flash-warning { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }

        /* ===========================
           FORM STYLES
        =========================== */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block; margin-bottom: 6px;
            font-family: 'Outfit', sans-serif; font-size: 0.85rem;
            font-weight: 600; color: var(--text-primary);
        }
        .form-label .req { color: var(--gold); margin-left: 2px; }
        .form-control {
            width: 100%; padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius); font-family: 'Inter', sans-serif;
            font-size: 0.9rem; color: var(--text-primary);
            background: var(--white); transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.12);
        }
        .form-control.error { border-color: #ef4444; }
        textarea.form-control { resize: vertical; min-height: 120px; }
        .form-error { color: #ef4444; font-size: 0.8rem; margin-top: 4px; font-family: 'Outfit', sans-serif; }
        select.form-control { cursor: pointer; appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-repeat: no-repeat; background-position: right 12px center;
            background-size: 16px; padding-right: 40px;
        }

        /* ===========================
           WHATSAPP FLOAT
        =========================== */
        .whatsapp-float {
            position: fixed; bottom: 28px; right: 28px; z-index: 9999;
            width: 58px; height: 58px;
            background: #25D366;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(37,211,102,0.4);
            transition: var(--transition);
        }
        .whatsapp-float:hover { transform: scale(1.12); box-shadow: 0 12px 32px rgba(37,211,102,0.5); }
        .whatsapp-float svg { color: var(--white); }

        /* ===========================
           RESPONSIVE
        =========================== */
        @media (max-width: 1024px) {
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 40px; }
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .nav, .header-phone { display: none; }
            .mobile-toggle { display: flex; }
            .section-pad { padding: 70px 0; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; gap: 40px; }
            .footer-bottom-inner { flex-direction: column; text-align: center; }
            .grid-4 { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .container { padding: 0 16px; }
            .section-pad { padding: 50px 0; }
        }

        /* ===========================
           SCROLL REVEAL
        =========================== */
        [data-aos] { pointer-events: none; }
        [data-aos].aos-animate { pointer-events: auto; }
    </style>
    
    @yield('styles')
    
    @if(!empty($siteSettings['google_analytics']))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['google_analytics'] }}"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','{{ $siteSettings['google_analytics'] }}');</script>
    @endif
</head>
<body>

    <!-- Announcement Bar -->
    @if(!empty($siteSettings['announcement_bar_enabled']) && $siteSettings['announcement_bar_enabled'])
    <div class="announcement-bar" role="complementary" aria-label="Announcement">
        {!! $siteSettings['announcement_bar'] ?? '🏭 Premium Kiosk Manufacturing | Custom Designs | <span>Free Consultation Available</span>' !!}
    </div>
    @endif

    <!-- Header -->
    <header class="header" id="main-header" role="banner">
        <div class="container">
            <div class="header-inner">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="logo" aria-label="{{ $siteSettings['site_name'] ?? 'Kovai Kiosk' }} - Home">
                    @if(!empty($siteSettings['logo']))
                        <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'Kovai Kiosk' }}" class="logo-img">
                    @else
                        <div class="logo-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                        </div>
                        <div class="logo-text">
                            {{ $siteSettings['site_name'] ?? 'Kovai Kiosk' }}
                            <small>Kiosk Manufacturers</small>
                        </div>
                    @endif
                </a>

                <!-- Desktop Nav -->
                <nav class="nav" role="navigation" aria-label="Main Navigation">
                    <div class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About Pathy</a>
                    </div>
                    <!-- Products Dropdown -->
                    <div class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products*') ? 'active' : '' }}">
                            Products
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>
                        <div class="nav-dropdown" role="menu">
                            <div class="nav-dropdown-inner">
                                @foreach($navCategories as $cat)
                                <a href="{{ route('products.category', $cat->slug) }}" class="nav-dropdown-link" role="menuitem">
                                    <div class="cat-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="2"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                                    </div>
                                    {{ $cat->name }}
                                </a>
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('products.index') }}" class="dropdown-view-all">
                                    View All Products →
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
                    </div>
                </nav>

                <!-- Actions -->
                <div class="header-actions">
                    <div class="header-phone">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.69 10a19.79 19.79 0 01-3.07-8.67A2 2 0 013.6 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 7.91a16 16 0 006 6l1.27-.85a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 15.92z"/></svg>
                        <a href="tel:{{ str_replace([' ', '-'], '', $siteSettings['phone1'] ?? '+919876543210') }}">
                            {{ $siteSettings['phone1'] ?? '+91 98765 43210' }}
                        </a>
                    </div>
                    <a href="{{ route('enquiry.create') }}" class="btn btn-primary btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        Get a Quote
                    </a>
                    <!-- Mobile Toggle -->
                    <button class="mobile-toggle" id="mobile-toggle" aria-label="Toggle menu" aria-expanded="false">
                        <span></span><span></span><span></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Nav -->
    <div class="mobile-nav" id="mobile-nav" aria-label="Mobile Navigation" role="navigation">
        <div>
            <a href="{{ route('home') }}" class="mobile-nav-link">Home</a>
            <a href="{{ route('about') }}" class="mobile-nav-link">About Pathy</a>
            <div>
                <div class="mobile-nav-link" style="cursor:pointer">
                    Products
                </div>
                <div class="mobile-nav-sub">
                    @foreach($navCategories as $cat)
                        <a href="{{ route('products.category', $cat->slug) }}">{{ $cat->name }}</a>
                    @endforeach
                    <a href="{{ route('products.index') }}">All Products</a>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="mobile-nav-link">Contact Us</a>
            <a href="{{ route('enquiry.create') }}" class="mobile-nav-link" style="color: var(--gold); font-weight: 700;">Get a Quote</a>
        </div>
    </div>

    <!-- Page Content -->
    <main id="main-content" role="main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer" role="contentinfo">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <!-- Brand -->
                    <div>
                        <div class="footer-logo-area">
                            @if(!empty($siteSettings['footer_logo']))
                                <img src="{{ asset('storage/' . $siteSettings['footer_logo']) }}" alt="{{ $siteSettings['site_name'] ?? 'Kovai Kiosk' }}" style="height:48px">
                            @else
                                <div class="footer-logo-text">{{ $siteSettings['site_name'] ?? 'Kovai Kiosk' }}</div>
                            @endif
                        </div>
                        <p class="footer-desc">{{ $siteSettings['footer_description'] ?? 'Leading manufacturer of premium smart kiosks, mobile carts and EV vehicles. We transform your business vision into extraordinary real-world experiences.' }}</p>
                        <div class="footer-social">
                            @if(!empty($siteSettings['facebook']))
                            <a href="{{ $siteSettings['facebook'] }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                            </a>
                            @endif
                            @if(!empty($siteSettings['instagram']))
                            <a href="{{ $siteSettings['instagram'] }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                            </a>
                            @endif
                            @if(!empty($siteSettings['youtube']))
                            <a href="{{ $siteSettings['youtube'] }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon fill="#0D1B2A" points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
                            </a>
                            @endif
                            @if(!empty($siteSettings['linkedin']))
                            <a href="{{ $siteSettings['linkedin'] }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="footer-col-title">Quick Links</h3>
                        <div class="footer-links">
                            <a href="{{ route('home') }}">Home</a>
                            <a href="{{ route('about') }}">About Us</a>
                            <a href="{{ route('products.index') }}">Our Products</a>
                            <a href="{{ route('contact') }}">Contact Us</a>
                            <a href="{{ route('enquiry.create') }}">Get a Quote</a>
                        </div>
                    </div>

                    <!-- Products -->
                    <div>
                        <h3 class="footer-col-title">Products</h3>
                        <div class="footer-links">
                            @foreach($navCategories as $cat)
                                <a href="{{ route('products.category', $cat->slug) }}">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="footer-col-title">Contact Us</h3>
                        @if(!empty($siteSettings['address']))
                        <div class="footer-contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>{{ $siteSettings['address'] }}</span>
                        </div>
                        @endif
                        @if(!empty($siteSettings['phone1']))
                        <div class="footer-contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.69 10a19.79 19.79 0 01-3.07-8.67A2 2 0 013.6 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 7.91a16 16 0 006 6l1.27-.85a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 15.92z"/></svg>
                            <div>
                                <a href="tel:{{ str_replace([' ', '-'], '', $siteSettings['phone1']) }}" style="color:inherit;display:block">{{ $siteSettings['phone1'] }}</a>
                                @if(!empty($siteSettings['phone2']))
                                <a href="tel:{{ str_replace([' ', '-'], '', $siteSettings['phone2']) }}" style="color:inherit;display:block">{{ $siteSettings['phone2'] }}</a>
                                @endif
                            </div>
                        </div>
                        @endif
                        @if(!empty($siteSettings['email']))
                        <div class="footer-contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <a href="mailto:{{ $siteSettings['email'] }}" style="color:inherit">{{ $siteSettings['email'] }}</a>
                        </div>
                        @endif
                        @if(!empty($siteSettings['business_hours']))
                        <div class="footer-contact-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>{{ $siteSettings['business_hours'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-inner">
                    <p class="footer-copyright">{{ $siteSettings['copyright_text'] ?? '© 2024 Kovai Kiosk. All Rights Reserved.' }}</p>
                    <p class="footer-copyright" style="color:rgba(255,255,255,0.25)">Premium Kiosk Manufacturing</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    @if(!empty($siteSettings['whatsapp']))
    <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}?text=Hello%2C%20I%20am%20interested%20in%20your%20kiosk%20products.%20Please%20share%20more%20details." 
       class="whatsapp-float" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.555 4.116 1.528 5.85L.057 23.428a.5.5 0 00.515.572l5.736-1.504A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.96 0-3.8-.528-5.383-1.449L4 21l.483-2.497A9.956 9.956 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
        </svg>
    </a>
    @endif

    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 700, once: true, offset: 60 });

        // Header scroll effect
        const header = document.getElementById('main-header');
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 20);
        });

        // Mobile nav toggle
        const toggle = document.getElementById('mobile-toggle');
        const mobileNav = document.getElementById('mobile-nav');
        toggle.addEventListener('click', () => {
            const isOpen = mobileNav.classList.toggle('open');
            toggle.classList.toggle('active');
            toggle.setAttribute('aria-expanded', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });

        // Lucide icons
        lucide.createIcons();

        // Auto-hide flash messages
        setTimeout(() => {
            document.querySelectorAll('.flash-message').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);
    </script>
    
    @yield('scripts')
</body>
</html>
