<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', $siteSettings['meta_title'] ?? 'Pathy Display Racks | Kovai Kiosk')</title>
    <meta name="description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Leading manufacturer of smart kiosks, push carts, and display solutions by Pathy Display Racks.')">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', $siteSettings['meta_title'] ?? 'Pathy Display Racks')">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Leading manufacturer of smart kiosks, push carts, and display solutions.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    <!-- Fonts: Poppins (Headings) & Inter (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    
    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <!-- Central Brand Theme CSS (pdr lime green & neutral grey) -->
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    
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
        {!! $siteSettings['announcement_bar'] ?? '🏭 <span>Pathy Display Racks</span> | Custom Display Kiosks & Solutions | <span>Free Consultation Available</span>' !!}
    </div>
    @endif

    <!-- Header / Navbar -->
    <header class="header" id="main-header" role="banner">
        <div class="container">
            <div class="header-inner">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="logo" aria-label="Pathy Display Racks - Home">
                    <img src="{{ asset('images/pdr-logo.png') }}" alt="Pathy Display Racks" class="logo-img">
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
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 12 15 18 9"/></svg>
                        </a>
                        <div class="nav-dropdown" role="menu">
                            <div class="nav-dropdown-inner">
                                @foreach($navCategories as $cat)
                                <a href="{{ route('products.category', $cat->slug) }}" class="nav-dropdown-link" role="menuitem">
                                    <div class="cat-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
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
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.69 10a19.79 19.79 0 01-3.07-8.67A2 2 0 013.6 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 7.91a16 16 0 006 6l1.27-.85a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 15.92z"/></svg>
                        <a href="tel:{{ str_replace([' ', '-'], '', $siteSettings['phone1'] ?? '+919876543210') }}">
                            {{ $siteSettings['phone1'] ?? '+91 98765 43210' }}
                        </a>
                    </div>
                    <a href="{{ route('enquiry.create') }}" class="btn btn-primary btn-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
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

    <!-- Mobile Navigation Drawer -->
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
                    <a href="{{ route('products.index') }}" style="font-weight:600;color:var(--brand-green);">All Products →</a>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="mobile-nav-link">Contact Us</a>
            <a href="{{ route('enquiry.create') }}" class="mobile-nav-link" style="color: var(--brand-green); font-weight: 700;">Get a Quote →</a>
        </div>
    </div>

    <!-- Page Content -->
    <main id="main-content" role="main">
        @yield('content')
    </main>

    <!-- Footer: Dark Grey (#4A4A4A) with Green Headings/Icons -->
    <footer class="footer" role="contentinfo">
        <div class="footer-top">
            <div class="container">
                <div class="footer-grid">
                    <!-- Brand -->
                    <div>
                        <div class="footer-logo-area">
                            <a href="{{ route('home') }}" aria-label="Pathy Display Racks">
                                <img src="{{ asset('images/pdr-logo.png') }}" alt="Pathy Display Racks" class="footer-logo-img">
                            </a>
                        </div>
                        <p class="footer-desc">{{ $siteSettings['footer_description'] ?? 'Pathy Display Racks – Leading manufacturer of premium display racks, smart kiosks, mobile carts and commercial business solutions. Transforming your spaces with durable, precision-engineered products.' }}</p>
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
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon fill="#4A4A4A" points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
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
                    <p class="footer-copyright">{{ $siteSettings['copyright_text'] ?? '© ' . date('Y') . ' Pathy Display Racks (Kovai Kiosk). All Rights Reserved.' }}</p>
                    <p class="footer-copyright" style="color:rgba(255,255,255,0.4)">Precision Display & Kiosk Engineering</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    @if(!empty($siteSettings['whatsapp']))
    <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}?text=Hello%2C%20I%20am%20interested%20in%20Pathy%20Display%20Racks%20products.%20Please%20share%20more%20details." 
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
        AOS.init({ duration: 600, once: true, offset: 50 });

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
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Auto-hide flash messages
        setTimeout(() => {
            document.querySelectorAll('.flash-message').forEach(el => {
                el.style.transition = 'opacity 0.4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            });
        }, 5000);
    </script>
    
    @yield('scripts')
</body>
</html>
