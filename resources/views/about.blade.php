@extends('layouts.app')

@section('title', 'About Pathy | Kovai Kiosk')
@section('meta_description', 'Learn about Kovai Kiosk — our story, vision, manufacturing expertise, and commitment to premium kiosk manufacturing in Coimbatore.')

@section('styles')
<style>
.about-hero-text { max-width: 700px; }
.stats-row {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 2px; background: var(--border);
    border-radius: var(--radius); overflow: hidden;
    margin: 60px 0;
}
.stat-box {
    background: var(--white); padding: 32px 24px; text-align: center;
}
.stat-box-num {
    font-family: 'Playfair Display', serif;
    font-size: 2.8rem; font-weight: 800; color: var(--gold);
    line-height: 1;
}
.stat-box-label { font-family: 'Outfit', sans-serif; font-size: 0.85rem; color: var(--text-muted); margin-top: 8px; }

.about-section { padding: 80px 0; }
.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
.about-img-box { border-radius: 20px; overflow: hidden; aspect-ratio: 4/3; box-shadow: var(--shadow-lg); background: var(--ivory-dark); }
.about-img-box img { width: 100%; height: 100%; object-fit: cover; }

.values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 40px; }
.value-card {
    background: var(--ivory);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 32px 24px; text-align: center;
    transition: var(--transition);
}
.value-card:hover { border-color: var(--gold); transform: translateY(-6px); box-shadow: var(--shadow-md); }
.value-icon {
    width: 64px; height: 64px; margin: 0 auto 20px;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;
}
.value-title { font-size: 1rem; font-weight: 700; margin-bottom: 10px; }
.value-text { font-size: 0.85rem; color: var(--text-muted); line-height: 1.7; }

.infra-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
.infra-item {
    display: flex; gap: 20px; align-items: flex-start;
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 24px;
    transition: var(--transition);
}
.infra-item:hover { border-color: rgba(201,168,76,0.4); box-shadow: var(--shadow-sm); }
.infra-num {
    font-family: 'Playfair Display', serif;
    font-size: 2rem; font-weight: 800; color: rgba(201,168,76,0.3);
    line-height: 1; flex-shrink: 0; min-width: 44px;
}
.infra-title { font-weight: 700; margin-bottom: 6px; }
.infra-text { font-size: 0.85rem; color: var(--text-muted); }

.dark-section {
    background: linear-gradient(160deg, var(--navy), var(--charcoal));
    padding: 100px 0; color: white;
}
.dark-section .section-title { color: white; }
.dark-section .section-subtitle { color: rgba(255,255,255,0.6); }
.expertise-list { display: flex; flex-direction: column; gap: 16px; }
.expertise-item {
    display: flex; gap: 16px; align-items: center;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: var(--radius); padding: 20px 24px;
    transition: var(--transition);
}
.expertise-item:hover { border-color: rgba(201,168,76,0.3); background: rgba(255,255,255,0.07); }
.expertise-check { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.expertise-text { font-family: 'Outfit', sans-serif; font-size: 0.95rem; font-weight: 500; }

@media (max-width: 768px) {
    .stats-row { grid-template-columns: repeat(2, 1fr); }
    .about-grid { grid-template-columns: 1fr; }
    .values-grid, .infra-grid { grid-template-columns: 1fr; }
}

/* =========================================================
   QUERY LOOP STYLE 3D OVERLAPPING PRODUCT CAROUSEL
========================================================= */
.about-queryloop-section {
    padding: 100px 0;
    background: linear-gradient(180deg, #FFFFFF 0%, #FAF8F4 50%, #F5F1E8 100%);
    position: relative;
    overflow: hidden;
}

.queryloop-carousel-wrap {
    position: relative;
    width: 100%;
    margin-top: 50px;
    padding: 20px 0 30px;
}

.queryloop-stage {
    position: relative;
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
    height: 520px;
    perspective: 1400px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.queryloop-card {
    position: absolute;
    width: 380px;
    max-width: 86vw;
    background: #FFFFFF;
    border-radius: 22px;
    overflow: hidden;
    border: 1px solid rgba(201, 168, 76, 0.2);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    transition:
        transform 0.65s cubic-bezier(0.25, 1, 0.5, 1),
        opacity 0.65s ease,
        box-shadow 0.65s ease,
        filter 0.65s ease,
        border-color 0.65s ease;
    will-change: transform, opacity;
    user-select: none;
    display: flex;
    flex-direction: column;
}

/* Center Card - Prominent in Foreground */
.queryloop-card.card-center {
    transform: translateX(0) scale(1.06) translateZ(50px);
    z-index: 10;
    opacity: 1;
    pointer-events: auto;
    border-color: rgba(201, 168, 76, 0.5);
    box-shadow:
        0 25px 65px rgba(0, 0, 0, 0.16),
        0 0 30px rgba(201, 168, 76, 0.18);
    filter: blur(0px);
}

/* Left Card - Partially behind center */
.queryloop-card.card-left {
    transform: translateX(-56%) scale(0.86) rotateY(4.5deg) translateZ(0);
    z-index: 5;
    opacity: 0.72;
    pointer-events: auto;
    cursor: pointer;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.10);
    filter: blur(0.5px);
}

.queryloop-card.card-left:hover {
    opacity: 0.88;
    transform: translateX(-54%) scale(0.88) rotateY(3deg) translateZ(10px);
}

/* Right Card - Partially behind center */
.queryloop-card.card-right {
    transform: translateX(56%) scale(0.86) rotateY(-4.5deg) translateZ(0);
    z-index: 5;
    opacity: 0.72;
    pointer-events: auto;
    cursor: pointer;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.10);
    filter: blur(0.5px);
}

.queryloop-card.card-right:hover {
    opacity: 0.88;
    transform: translateX(54%) scale(0.88) rotateY(-3deg) translateZ(10px);
}

/* Hidden / Offstage Cards */
.queryloop-card.card-hidden-left {
    transform: translateX(-120%) scale(0.7) translateZ(-50px);
    z-index: 1;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

.queryloop-card.card-hidden-right {
    transform: translateX(120%) scale(0.7) translateZ(-50px);
    z-index: 1;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

/* Card Visual Header */
.queryloop-card-media {
    position: relative;
    width: 100%;
    aspect-ratio: 16/10;
    overflow: hidden;
    background: #1A2E45;
}

.queryloop-card-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.queryloop-card.card-center:hover .queryloop-card-media img {
    transform: scale(1.06);
}

.queryloop-badge-cat {
    position: absolute;
    top: 14px;
    left: 14px;
    background: rgba(13, 27, 42, 0.82);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(201, 168, 76, 0.4);
    border-radius: 50px;
    padding: 4px 12px;
    font-size: 0.7rem;
    font-family: 'Outfit', sans-serif;
    font-weight: 700;
    color: var(--gold-light);
    letter-spacing: 1px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    z-index: 2;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
}

.queryloop-badge-custom {
    position: absolute;
    top: 14px;
    right: 14px;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: #FFFFFF;
    border-radius: 50px;
    padding: 4px 12px;
    font-size: 0.68rem;
    font-family: 'Outfit', sans-serif;
    font-weight: 700;
    letter-spacing: 0.5px;
    z-index: 2;
    box-shadow: 0 4px 12px rgba(201, 168, 76, 0.4);
}

/* Card Information Body */
.queryloop-card-body {
    padding: 22px 24px 26px;
    background: #FFFFFF;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.queryloop-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 8px;
    line-height: 1.3;
}

.queryloop-card-desc {
    font-family: 'Inter', sans-serif;
    font-size: 0.82rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 20px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 40px;
}

.queryloop-card-action {
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.queryloop-card-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'Outfit', sans-serif;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--navy);
    transition: var(--transition);
}

.queryloop-card.card-center .queryloop-card-btn {
    color: var(--gold-dark);
}

.queryloop-card.card-center:hover .queryloop-card-btn {
    color: var(--gold);
    transform: translateX(4px);
}

.queryloop-card-arrow {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(201, 168, 76, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gold-dark);
    transition: all 0.25s ease;
}

.queryloop-card.card-center:hover .queryloop-card-arrow {
    background: var(--gold);
    color: #FFFFFF;
    transform: scale(1.1);
}

/* Circular Navigation Buttons */
.queryloop-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #FFFFFF;
    border: 1px solid rgba(201, 168, 76, 0.35);
    color: var(--text-primary);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 25;
    cursor: pointer;
    transition: all 0.25s ease;
}

.queryloop-prev {
    left: calc(50% - 470px);
}

.queryloop-next {
    right: calc(50% - 470px);
}

.queryloop-nav-btn:hover {
    background: var(--gold);
    color: #FFFFFF;
    border-color: var(--gold);
    box-shadow: 0 10px 30px rgba(201, 168, 76, 0.45);
    transform: translateY(-50%) scale(1.08);
}

/* Pagination Dots */
.queryloop-dots {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 24px;
}

.queryloop-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.18);
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
    border: none;
}

.queryloop-dot.active {
    width: 24px;
    border-radius: 10px;
    background: var(--gold);
    box-shadow: 0 0 10px rgba(201, 168, 76, 0.5);
}

/* Responsive */
@media (max-width: 1024px) {
    .queryloop-stage { max-width: 900px; height: 500px; }
    .queryloop-card { width: 330px; }
    .queryloop-card.card-left { transform: translateX(-48%) scale(0.86) rotateY(4deg); }
    .queryloop-card.card-right { transform: translateX(48%) scale(0.86) rotateY(-4deg); }
    .queryloop-prev { left: 16px; }
    .queryloop-next { right: 16px; }
}

@media (max-width: 768px) {
    .about-queryloop-section { padding: 70px 0; }
    .queryloop-stage { height: 480px; }
    .queryloop-card { width: 300px; max-width: 84vw; }
    .queryloop-card.card-center { transform: translateX(0) scale(1.02); }
    .queryloop-card.card-left { transform: translateX(-70%) scale(0.82) rotateY(3deg); opacity: 0.25; pointer-events: none; }
    .queryloop-card.card-right { transform: translateX(70%) scale(0.82) rotateY(-3deg); opacity: 0.25; pointer-events: none; }
    .queryloop-card-title { font-size: 1.15rem; }
    .queryloop-card-desc { font-size: 0.78rem; min-height: 36px; }
    .queryloop-nav-btn { width: 40px; height: 40px; }
    .queryloop-prev { left: 8px; }
    .queryloop-next { right: 8px; }
}

@media (prefers-reduced-motion: reduce) {
    .queryloop-card {
        transition-duration: 0.01ms !important;
    }
}
</style>
@endsection

@section('content')

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="breadcrumb-sep">›</span>
                <span>About Pathy</span>
            </nav>
            <h1>About Pathy</h1>
            <p>The story of craftsmanship, passion, and a relentless pursuit of excellence in kiosk manufacturing.</p>
        </div>
    </div>
</section>

<!-- About Company -->
<section class="about-section" style="background:var(--white)">
    <div class="container">
        <div class="about-grid">
            <div data-aos="fade-right">
                <div class="section-label">Our Company</div>
                <h2 class="section-title">More Than Just Manufacturers</h2>
                <p style="color:var(--text-secondary);margin-bottom:16px;line-height:1.8">
                    Kovai Kiosk was founded with a singular vision: to create commercial spaces that inspire customers, empower businesses, and stand the test of time. Based in Coimbatore — the manufacturing capital of Tamil Nadu — we have grown from a small workshop into one of South India's most trusted kiosk manufacturing companies.
                </p>
                <p style="color:var(--text-secondary);line-height:1.8">
                    Our founder, Pathy, started this journey over 15 years ago with a simple belief — that every business, big or small, deserves a beautiful, functional and durable commercial space. Today, we have delivered over 500 projects across India, serving clients from leading retail chains, food and beverage brands, hotels, malls and individual entrepreneurs.
                </p>
                <div style="margin-top:32px;display:flex;gap:20px;flex-wrap:wrap">
                    <a href="{{ route('enquiry.create') }}" class="btn btn-primary" id="about-quote-btn">Get a Free Consultation</a>
                    <a href="{{ route('contact') }}" class="btn btn-outline" id="about-contact-btn">Contact Us</a>
                </div>
            </div>
            <div data-aos="fade-left">
                <div class="about-img-box">
                    <img src="{{ asset('images/about-factory.jpg') }}" alt="Kovai Kiosk Manufacturing Facility" loading="lazy" onerror="this.parentElement.style.background='linear-gradient(135deg,#f0ede6,#1C1C1E)'">
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-row" data-aos="fade-up">
            <div class="stat-box">
                <div class="stat-box-num" id="stat-years">15+</div>
                <div class="stat-box-label">Years of Experience</div>
            </div>
            <div class="stat-box">
                <div class="stat-box-num" id="stat-projects">500+</div>
                <div class="stat-box-label">Projects Delivered</div>
            </div>
            <div class="stat-box">
                <div class="stat-box-num" id="stat-clients">300+</div>
                <div class="stat-box-label">Happy Clients</div>
            </div>
            <div class="stat-box">
                <div class="stat-box-num" id="stat-cities">50+</div>
                <div class="stat-box-label">Cities Served</div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="about-section" style="background:var(--ivory)">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">Our Purpose</div>
            <h2 class="section-title">Vision & Mission</h2>
        </div>
        <div class="grid-2" style="margin-top:40px">
            <div class="value-card" data-aos="fade-right" style="text-align:left;background:linear-gradient(135deg,var(--navy),var(--charcoal));color:white;border:none">
                <div class="value-icon" style="background:linear-gradient(135deg,var(--gold),var(--gold-dark))">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                <h3 style="font-size:1.3rem;margin-bottom:12px;color:var(--white)">Our Vision</h3>
                <p style="color:rgba(255,255,255,0.7);line-height:1.8">To be South India's most trusted and innovative kiosk manufacturing company, known for crafting commercial spaces that inspire success and build lasting brands.</p>
            </div>
            <div class="value-card" data-aos="fade-left" style="text-align:left">
                <div class="value-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <h3 style="font-size:1.3rem;margin-bottom:12px">Our Mission</h3>
                <p style="color:var(--text-secondary);line-height:1.8">To deliver premium, customized kiosk solutions that exceed client expectations through innovative design, superior craftsmanship, and end-to-end professional service — at every price point.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== QUERY LOOP 3D OVERLAPPING PRODUCT CAROUSEL ===== -->
<section class="about-queryloop-section" id="about-showcase" aria-label="Featured Product Showcase">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">Engineering Excellence</div>
            <h2 class="section-title">Our Signature Manufacturing Showcase</h2>
            <p class="section-subtitle">Explore custom-engineered Smart Kiosks, Gourmet Mobile Carts, and EV Commercial Units designed and fabricated by Pathy & Kovai Kiosk craftsmen.</p>
        </div>

        @if(isset($showcaseProducts) && $showcaseProducts->isNotEmpty())
        <div class="queryloop-carousel-wrap" id="queryloop-container" data-aos="fade-up" data-aos-delay="100">
            <!-- Navigation Buttons -->
            <button type="button" class="queryloop-nav-btn queryloop-prev" id="queryloop-prev" aria-label="Previous Product">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button type="button" class="queryloop-nav-btn queryloop-next" id="queryloop-next" aria-label="Next Product">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <!-- 3D Overlapping Stage -->
            <div class="queryloop-stage" id="queryloop-stage" role="region" aria-label="3D Product Carousel" aria-roledescription="carousel">
                @foreach($showcaseProducts as $index => $prod)
                <div class="queryloop-card {{ $index === 0 ? 'card-center' : ($index === 1 ? 'card-right' : ($index === count($showcaseProducts) - 1 ? 'card-left' : 'card-hidden-right')) }}"
                     data-card-index="{{ $index }}"
                     role="group"
                     aria-roledescription="slide"
                     aria-label="{{ $prod->name }}">
                    
                    <!-- Card Top Media -->
                    <div class="queryloop-card-media">
                        <img src="{{ $prod->primary_image_url }}" alt="{{ $prod->name }}" loading="{{ $index < 3 ? 'eager' : 'lazy' }}" onerror="this.onerror=null;this.src='{{ asset('images/about-factory.jpg') }}'">
                        
                        @if($prod->category)
                        <div class="queryloop-badge-cat">
                            @if(stripos($prod->category->name, 'kiosk') !== false)
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                            @elseif(stripos($prod->category->name, 'cart') !== false)
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            @else
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            @endif
                            <span>{{ $prod->category->name }}</span>
                        </div>
                        @endif

                        @if(!empty($prod->custom_badge))
                        <div class="queryloop-badge-custom">
                            ★ {{ $prod->custom_badge }}
                        </div>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="queryloop-card-body">
                        <h3 class="queryloop-card-title">{{ $prod->name }}</h3>
                        <p class="queryloop-card-desc">
                            {{ $prod->short_description ?? Str::limit($prod->description, 95) }}
                        </p>

                        <div class="queryloop-card-action">
                            @if($prod->category)
                            <a href="{{ route('products.show', [$prod->category->slug, $prod->slug]) }}" class="queryloop-card-btn">
                                <span>Explore Specifications</span>
                                <div class="queryloop-card-arrow">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </div>
                            </a>
                            @else
                            <a href="{{ route('products.index') }}" class="queryloop-card-btn">
                                <span>View Catalogue</span>
                                <div class="queryloop-card-arrow">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination Dots -->
            <div class="queryloop-dots" id="queryloop-dots" role="tablist" aria-label="Showcase Pagination">
                @foreach($showcaseProducts as $index => $prod)
                <button type="button" class="queryloop-dot {{ $index === 0 ? 'active' : '' }}" data-dot-index="{{ $index }}" role="tab" aria-selected="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Go to product {{ $index + 1 }}"></button>
                @endforeach
            </div>
        </div>
        @else
        <!-- Graceful fallback if empty -->
        <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:20px;margin-top:40px;border:1px solid rgba(201,168,76,0.25)">
            <p style="color:var(--text-muted);font-size:1rem">Showcase items currently being updated. Please check our complete catalogue below.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="margin-top:20px">Explore All Products</a>
        </div>
        @endif
    </div>
</section>

<!-- Manufacturing Expertise -->
<section class="dark-section">
    <div class="container">
        <div class="about-grid">
            <div data-aos="fade-right">
                <div class="section-label" style="color:var(--gold-light)">
                    <span style="background:var(--gold-light);width:30px;height:1px;display:inline-block;vertical-align:middle"></span>
                    What We Do
                    <span style="background:var(--gold-light);width:30px;height:1px;display:inline-block;vertical-align:middle"></span>
                </div>
                <h2 class="section-title">Our Manufacturing Expertise</h2>
                <p style="color:rgba(255,255,255,0.6);margin-bottom:32px;line-height:1.8">Our state-of-the-art manufacturing facility in Coimbatore is equipped with the latest technology and staffed by experienced craftsmen.</p>
                <div class="expertise-list">
                    @php
                    $expertise = [
                        'Custom Metal Fabrication (MIG, TIG & ARC Welding)',
                        'Stainless Steel & Powder Coat Finishing',
                        'CNC Cutting & Precision Engineering',
                        'Vinyl Wrapping & Digital Printing',
                        'LED Lighting Installation',
                        'Electrical & Point-of-Sale Integration',
                        'Canopy & Roofing Systems',
                        'Cold Chain & Refrigeration Integration',
                    ];
                    @endphp
                    @foreach($expertise as $item)
                    <div class="expertise-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <div class="expertise-check">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <span class="expertise-text">{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div data-aos="fade-left">
                <div class="about-img-box">
                    <img src="{{ asset('images/manufacturing2.jpg') }}" alt="Manufacturing Expertise" loading="lazy" onerror="this.parentElement.style.background='#1A2E45'">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="about-section" style="background:var(--white)">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">Our Commitment</div>
            <h2 class="section-title">Why We're Different</h2>
            <p class="section-subtitle">Our values are the foundation of everything we build. They guide every decision, every weld, and every client interaction.</p>
        </div>
        <div class="values-grid">
            @php
            $values = [
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>', 'title' => 'Quality First', 'text' => 'We never compromise on material quality or craftsmanship. Every product undergoes rigorous quality inspection.'],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>', 'title' => 'Client-Centric Approach', 'text' => 'Your vision drives our design process. We listen, we adapt, and we deliver exactly what you envision.'],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>', 'title' => 'Innovation in Design', 'text' => 'We continuously evolve our designs to incorporate the latest trends in retail and commercial environments.'],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>', 'title' => 'On-Time Delivery', 'text' => 'We understand that your business timelines matter. We have a 98% on-time delivery record.'],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>', 'title' => 'Transparent Pricing', 'text' => 'No hidden costs. We provide detailed, itemized quotations so you always know what you are paying for.'],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>', 'title' => 'After-Sales Support', 'text' => 'Our relationship does not end at delivery. We provide comprehensive after-sales support and maintenance services.'],
            ];
            @endphp
            @foreach($values as $value)
            <div class="value-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="value-icon">{!! $value['icon'] !!}</div>
                <h3 class="value-title">{{ $value['title'] }}</h3>
                <p class="value-text">{{ $value['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Infrastructure -->
<section class="about-section" style="background:var(--ivory)">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">Our Facility</div>
            <h2 class="section-title">World-Class Infrastructure</h2>
            <p class="section-subtitle">Our manufacturing facility is designed to produce premium products at scale without compromising on quality.</p>
        </div>
        <div class="infra-grid" style="margin-top:40px">
            @php
            $infra = [
                ['num' => '01', 'title' => '20,000 sq.ft. Factory Floor', 'text' => 'A spacious, purpose-built manufacturing facility with separate zones for fabrication, finishing and assembly.'],
                ['num' => '02', 'title' => 'CNC Precision Machinery', 'text' => 'State-of-the-art CNC cutting machines ensure precision engineering to tolerances of less than 0.1mm.'],
                ['num' => '03', 'title' => 'Industrial Powder Coating Plant', 'text' => 'Full in-house powder coating facility for durable, corrosion-resistant, premium finishes in any colour.'],
                ['num' => '04', 'title' => 'Digital Printing & Wrapping', 'text' => 'Professional large-format digital printing for signage, vinyl wraps and custom branding applications.'],
                ['num' => '05', 'title' => '50+ Skilled Craftsmen', 'text' => 'Our team includes experienced welders, fabricators, painters, and electricians — all under one roof.'],
                ['num' => '06', 'title' => 'Quality Control Lab', 'text' => 'Dedicated quality inspection area with measuring tools, finish testing and structural load testing.'],
            ];
            @endphp
            @foreach($infra as $item)
            <div class="infra-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="infra-num">{{ $item['num'] }}</div>
                <div>
                    <div class="infra-title">{{ $item['title'] }}</div>
                    <div class="infra-text">{{ $item['text'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section style="background:var(--charcoal);padding:80px 0;text-align:center">
    <div class="container" data-aos="fade-up">
        <div class="section-label" style="justify-content:center">Start Your Project</div>
        <h2 style="font-size:clamp(1.8rem,4vw,2.8rem);color:var(--white);margin-bottom:16px">Ready to Work With Us?</h2>
        <p style="color:rgba(255,255,255,0.6);margin-bottom:40px;font-size:1.1rem">Let's discuss your project and see how we can bring your vision to life.</p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
            <a href="{{ route('enquiry.create') }}" class="btn btn-primary" id="about-cta-btn">Request a Quote</a>
            <a href="{{ route('contact') }}" class="btn btn-outline-white" id="about-cta-contact-btn">Visit Our Factory</a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('queryloop-container');
    const stage = document.getElementById('queryloop-stage');
    if (!stage) return;

    const cards = Array.from(stage.querySelectorAll('.queryloop-card'));
    const prevBtn = document.getElementById('queryloop-prev');
    const nextBtn = document.getElementById('queryloop-next');
    const dotsContainer = document.getElementById('queryloop-dots');
    const dots = dotsContainer ? Array.from(dotsContainer.querySelectorAll('.queryloop-dot')) : [];

    const total = cards.length;
    if (total === 0) return;

    let currentIndex = 0;
    let isTransitioning = false;
    let autoSlideTimer = null;
    let isPaused = false;
    const intervalTime = 4600; // ms

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Apply layout positions according to active center index
    function updatePositions(newIndex, direction = 'next') {
        if (isTransitioning && newIndex === currentIndex) return;
        isTransitioning = true;

        const leftIndex = (newIndex - 1 + total) % total;
        const rightIndex = (newIndex + 1) % total;

        cards.forEach((card, idx) => {
            // Remove previous positioning classes
            card.classList.remove('card-center', 'card-left', 'card-right', 'card-hidden-left', 'card-hidden-right');

            if (idx === newIndex) {
                card.classList.add('card-center');
                card.setAttribute('aria-hidden', 'false');
            } else if (idx === leftIndex && total > 1) {
                card.classList.add('card-left');
                card.setAttribute('aria-hidden', 'false');
            } else if (idx === rightIndex && total > 2) {
                card.classList.add('card-right');
                card.setAttribute('aria-hidden', 'false');
            } else {
                // Determine whether hidden on left or right side for smooth offstage transitions
                const diff = (idx - newIndex + total) % total;
                if (diff < total / 2) {
                    card.classList.add('card-hidden-right');
                } else {
                    card.classList.add('card-hidden-left');
                }
                card.setAttribute('aria-hidden', 'true');
            }
        });

        // Synchronize dots
        if (dots.length > 0) {
            dots.forEach((dot, idx) => {
                const isActive = idx === newIndex;
                dot.classList.toggle('active', isActive);
                dot.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
        }

        currentIndex = newIndex;

        setTimeout(() => {
            isTransitioning = false;
        }, 650);
    }

    function next() {
        const target = (currentIndex + 1) % total;
        updatePositions(target, 'next');
    }

    function prev() {
        const target = (currentIndex - 1 + total) % total;
        updatePositions(target, 'prev');
    }

    // Auto Play Timer
    function startAutoPlay() {
        if (prefersReducedMotion || total <= 1) return;
        stopAutoPlay();
        autoSlideTimer = setInterval(() => {
            if (!isPaused) {
                next();
            }
        }, intervalTime);
    }

    function stopAutoPlay() {
        if (autoSlideTimer) {
            clearInterval(autoSlideTimer);
            autoSlideTimer = null;
        }
    }

    // Button event listeners
    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            next();
            startAutoPlay();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            prev();
            startAutoPlay();
        });
    }

    // Direct card click: clicking left card brings it to center, clicking right card brings it to center
    cards.forEach((card, index) => {
        card.addEventListener('click', function (e) {
            // Don't intercept click on action links/buttons
            if (e.target.closest('.queryloop-card-btn') || e.target.closest('a')) {
                return;
            }

            if (card.classList.contains('card-left')) {
                e.preventDefault();
                prev();
                startAutoPlay();
            } else if (card.classList.contains('card-right')) {
                e.preventDefault();
                next();
                startAutoPlay();
            }
        });
    });

    // Pagination Dots click
    dots.forEach((dot, index) => {
        dot.addEventListener('click', (e) => {
            e.preventDefault();
            updatePositions(index, index > currentIndex ? 'next' : 'prev');
            startAutoPlay();
        });
    });

    // Pause on Hover
    if (container) {
        container.addEventListener('mouseenter', () => { isPaused = true; });
        container.addEventListener('mouseleave', () => { isPaused = false; });
    }

    // Mobile Swipe / Touch Events
    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    let touchEndY = 0;

    stage.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
        isPaused = true;
    }, { passive: true });

    stage.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        touchEndY = e.changedTouches[0].screenY;
        isPaused = false;

        const deltaX = touchEndX - touchStartX;
        const deltaY = touchEndY - touchStartY;

        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 40) {
            if (deltaX < 0) {
                next();
            } else {
                prev();
            }
            startAutoPlay();
        }
    }, { passive: true });

    // Initial position setup
    updatePositions(0);
    startAutoPlay();
});
</script>
@endsection
