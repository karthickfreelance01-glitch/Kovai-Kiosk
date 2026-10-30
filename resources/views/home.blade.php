@extends('layouts.app')

@section('title', ($siteSettings['meta_title'] ?? 'Kovai Kiosk | Premium Kiosk Manufacturers'))

@section('styles')
<style>
/* ===========================
   HERO SECTION
=========================== */
.hero {
    position: relative;
    min-height: 100vh;
    display: flex; align-items: center;
    background: linear-gradient(160deg, #0D1B2A 0%, #1A2E45 35%, #1C1C1E 100%);
    overflow: hidden;
}
.hero-bg-shapes {
    position: absolute; inset: 0; pointer-events: none;
}
.hero-shape-1 {
    position: absolute; width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,0.10) 0%, transparent 70%);
    top: -200px; right: -100px;
    animation: pulse-slow 6s ease-in-out infinite;
}
.hero-shape-2 {
    position: absolute; width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
    bottom: -100px; left: -50px;
    animation: pulse-slow 8s ease-in-out infinite reverse;
}
.hero-grid-overlay {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(201,168,76,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(201,168,76,0.04) 1px, transparent 1px);
    background-size: 60px 60px;
}
@keyframes pulse-slow {
    0%, 100% { transform: scale(1) translate(0,0); }
    50% { transform: scale(1.08) translate(20px, -20px); }
}

.hero-content {
    position: relative; z-index: 2;
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 80px; align-items: center;
    padding: 80px 0;
}
.hero-eyebrow {
    display: inline-flex; align-items: center; gap: 10px;
    background: rgba(201,168,76,0.12);
    border: 1px solid rgba(201,168,76,0.3);
    border-radius: 50px; padding: 6px 18px;
    font-family: 'Outfit', sans-serif; font-size: 0.75rem;
    font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase;
    color: var(--gold-light); margin-bottom: 28px;
}
.hero-eyebrow-dot {
    width: 6px; height: 6px; background: var(--gold);
    border-radius: 50%;
    animation: blink 2s ease-in-out infinite;
}
@keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.4rem, 5vw, 4rem);
    font-weight: 800; line-height: 1.1;
    color: var(--white); margin-bottom: 24px;
}
.hero-title .highlight {
    background: linear-gradient(135deg, var(--gold-light), var(--gold));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-subtitle {
    font-size: 1.1rem; line-height: 1.8;
    color: rgba(255,255,255,0.65);
    margin-bottom: 44px; max-width: 500px;
}
.hero-cta { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 56px; }
.hero-stats {
    display: flex; gap: 40px;
    padding-top: 40px;
    border-top: 1px solid rgba(255,255,255,0.1);
}
.hero-stat {}
.hero-stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 2rem; font-weight: 700;
    color: var(--gold-light);
}
.hero-stat-label {
    font-family: 'Outfit', sans-serif; font-size: 0.8rem;
    font-weight: 500; color: rgba(255,255,255,0.5);
    text-transform: uppercase; letter-spacing: 1px;
}

/* Hero Visual */
.hero-visual {
    position: relative; display: flex; align-items: center; justify-content: center;
}
.hero-image-frame {
    position: relative; width: 100%;
}
.hero-image-main {
    width: 100%; aspect-ratio: 4/5;
    border-radius: 24px; overflow: hidden;
    box-shadow: 0 40px 100px rgba(0,0,0,0.5);
    border: 1px solid rgba(201,168,76,0.2);
}
.hero-image-main img {
    width: 100%; height: 100%; object-fit: cover;
}
.hero-badge {
    position: absolute; bottom: -20px; left: -20px;
    background: var(--white); border-radius: 16px;
    padding: 16px 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.25);
    display: flex; gap: 14px; align-items: center;
    min-width: 200px;
}
.hero-badge-icon {
    width: 48px; height: 48px;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.hero-badge-text { font-family: 'Outfit', sans-serif; }
.hero-badge-text strong { display: block; font-size: 1rem; font-weight: 700; color: var(--text-primary); }
.hero-badge-text span { font-size: 0.78rem; color: var(--text-muted); }

.hero-floating-card {
    position: absolute; top: 30px; right: -30px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(201,168,76,0.25);
    border-radius: 16px; padding: 16px 20px;
    color: var(--white); min-width: 160px;
    animation: float 4s ease-in-out infinite;
}
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
}
.hero-floating-card-label { font-family: 'Outfit', sans-serif; font-size: 0.7rem; letter-spacing: 1.5px; text-transform: uppercase; color: var(--gold-light); margin-bottom: 6px; }
.hero-floating-card-val { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; }
.hero-floating-card-sub { font-size: 0.75rem; color: rgba(255,255,255,0.5); }

/* ===========================
   BRAND INTRO SECTION
=========================== */
.brand-intro {
    background: var(--ivory);
    padding: 100px 0;
}
.brand-intro-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 80px; align-items: center;
}
.brand-tag {
    display: inline-flex; gap: 8px; align-items: center;
    background: rgba(201,168,76,0.1);
    border: 1px solid rgba(201,168,76,0.3);
    border-radius: 6px; padding: 4px 14px;
    font-family: 'Outfit', sans-serif; font-size: 0.75rem;
    font-weight: 700; letter-spacing: 2px; text-transform: uppercase;
    color: var(--gold); margin-bottom: 20px;
}
.brand-intro-features { margin-top: 32px; display: flex; flex-direction: column; gap: 16px; }
.brand-feature {
    display: flex; gap: 16px; align-items: flex-start;
}
.brand-feature-icon {
    width: 42px; height: 42px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    border-radius: 10px; display: flex; align-items: center; justify-content: center;
    color: white; margin-top: 2px;
}
.brand-feature-text h4 {
    font-family: 'Outfit', sans-serif; font-size: 0.95rem;
    font-weight: 700; margin-bottom: 4px;
}
.brand-feature-text p { font-size: 0.85rem; color: var(--text-muted); }

.brand-image-stack { position: relative; }
.brand-img-main {
    width: 85%; aspect-ratio: 4/3; border-radius: 20px; overflow: hidden;
    box-shadow: var(--shadow-lg);
}
.brand-img-main img { width: 100%; height: 100%; object-fit: cover; }
.brand-img-accent {
    position: absolute; bottom: -30px; right: 0;
    width: 50%; aspect-ratio: 1;
    border-radius: 16px; overflow: hidden;
    box-shadow: var(--shadow-lg);
    border: 4px solid var(--white);
}
.brand-img-accent img { width: 100%; height: 100%; object-fit: cover; }

/* ===========================
   PRODUCT CATEGORIES SECTION
=========================== */
.categories-section {
    padding: 100px 0;
    background: var(--white);
}
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 28px;
    margin-top: 20px;
}
.category-card {
    position: relative; border-radius: 20px; overflow: hidden;
    aspect-ratio: 4/3;
    cursor: pointer; group: true;
}
.category-card::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 60%, transparent 100%);
    z-index: 1;
    transition: opacity 0.4s;
}
.category-card:hover::before { opacity: 0.9; }
.category-card-img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}
.category-card:hover .category-card-img { transform: scale(1.08); }
.category-card-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--navy), var(--charcoal));
    display: flex; align-items: center; justify-content: center;
}
.category-card-content {
    position: absolute; bottom: 0; left: 0; right: 0;
    z-index: 2; padding: 28px;
    transform: translateY(20px);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.category-card:hover .category-card-content { transform: translateY(0); }
.category-card-icon {
    width: 48px; height: 48px;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
    color: white; margin-bottom: 14px;
}
.category-card-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem; font-weight: 700; color: var(--white);
    margin-bottom: 8px;
}
.category-card-desc {
    font-size: 0.85rem; color: rgba(255,255,255,0.7);
    margin-bottom: 16px;
    max-height: 0; overflow: hidden;
    transition: max-height 0.3s ease;
}
.category-card:hover .category-card-desc { max-height: 60px; }
.category-card-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-family: 'Outfit', sans-serif; font-size: 0.85rem;
    font-weight: 700; color: var(--gold-light);
    letter-spacing: 0.5px;
}

/* ===========================
   FEATURED PRODUCTS
=========================== */
.featured-products {
    padding: 100px 0;
    background: var(--ivory);
}
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 28px;
    margin-bottom: 48px;
}

/* ===========================
   WHY CHOOSE US
=========================== */
.why-us-section {
    padding: 100px 0;
    background: linear-gradient(160deg, var(--navy) 0%, var(--charcoal) 100%);
    position: relative; overflow: hidden;
}
.why-us-section::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C9A84C' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.why-us-section .section-label { color: var(--gold-light); }
.why-us-section .section-label::before, .why-us-section .section-label::after { background: var(--gold-light); }
.why-us-section .section-title { color: var(--white); }
.why-us-section .section-subtitle { color: rgba(255,255,255,0.6); }

.why-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    position: relative; z-index: 1;
}
.why-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: var(--radius-lg);
    padding: 36px 28px;
    transition: var(--transition);
}
.why-card:hover {
    background: rgba(255,255,255,0.07);
    border-color: rgba(201,168,76,0.3);
    transform: translateY(-6px);
}
.why-icon {
    width: 60px; height: 60px;
    background: linear-gradient(135deg, rgba(201,168,76,0.2), rgba(201,168,76,0.05));
    border: 1px solid rgba(201,168,76,0.3);
    border-radius: 16px; display: flex; align-items: center; justify-content: center;
    color: var(--gold-light); margin-bottom: 24px;
    transition: var(--transition);
}
.why-card:hover .why-icon { background: linear-gradient(135deg, var(--gold), var(--gold-dark)); border-color: transparent; color: white; }
.why-card-title { font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 700; color: var(--white); margin-bottom: 10px; }
.why-card-text { font-size: 0.875rem; color: rgba(255,255,255,0.5); line-height: 1.7; }

/* ===========================
   PROCESS SECTION
=========================== */
.process-section { padding: 100px 0; background: var(--white); }
.process-timeline {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
    position: relative;
    margin-top: 20px;
}
.process-timeline::before {
    content: '';
    position: absolute; top: 44px; left: 16.67%;
    right: 16.67%; height: 2px;
    background: linear-gradient(90deg, var(--gold), var(--gold-light), var(--gold));
}
.process-step { padding: 0 20px; text-align: center; position: relative; }
.process-num {
    width: 88px; height: 88px;
    border: 2px solid var(--gold);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700;
    color: var(--gold); margin: 0 auto 24px;
    background: var(--white);
    position: relative; z-index: 1;
    transition: var(--transition);
}
.process-step:hover .process-num {
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: var(--white); border-color: transparent;
    transform: scale(1.1);
}
.process-title { font-size: 1rem; font-weight: 700; margin-bottom: 10px; }
.process-desc { font-size: 0.83rem; color: var(--text-muted); line-height: 1.7; }

/* ===========================
   PROJECTS SECTION
=========================== */
.projects-section {
    padding: 100px 0;
    background: var(--ivory);
}
.projects-gallery {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.project-item {
    position: relative; border-radius: var(--radius-lg);
    overflow: hidden; aspect-ratio: 3/4;
    cursor: pointer;
}
.project-item.wide {
    grid-column: span 2; aspect-ratio: 16/9;
}
.project-item img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.project-item-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--charcoal-light), var(--navy));
    display: flex; align-items: center; justify-content: center;
}
.project-item:hover img { transform: scale(1.08); }
.project-item::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);
    opacity: 0; transition: opacity 0.4s;
}
.project-item:hover::after { opacity: 1; }
.project-item-overlay {
    position: absolute; bottom: 0; left: 0; right: 0;
    z-index: 2; padding: 20px;
    transform: translateY(100%); transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}
.project-item:hover .project-item-overlay { transform: translateY(0); }
.project-item-cat {
    font-family: 'Outfit', sans-serif; font-size: 0.7rem; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: var(--gold-light);
    margin-bottom: 4px;
}
.project-item-title { font-size: 0.95rem; font-weight: 700; color: var(--white); }

/* ===========================
   CTA SECTION
=========================== */
.cta-section {
    padding: 100px 0;
    background: linear-gradient(135deg, var(--gold-dark), var(--gold), var(--gold-light));
    position: relative; overflow: hidden;
}
.cta-section::before {
    content: '';
    position: absolute; inset: 0;
    background: rgba(0,0,0,0.08);
}
.cta-content { position: relative; z-index: 1; text-align: center; }
.cta-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800; color: var(--white); margin-bottom: 16px;
    text-shadow: 0 2px 20px rgba(0,0,0,0.2);
}
.cta-subtitle { font-size: 1.1rem; color: rgba(255,255,255,0.85); margin-bottom: 40px; }
.cta-buttons { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
.btn-cta-white {
    background: var(--white); color: var(--gold-dark);
    font-family: 'Outfit', sans-serif; font-weight: 700;
    padding: 16px 40px; border-radius: 50px; font-size: 1rem;
    transition: var(--transition); display: inline-flex; align-items: center; gap: 8px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}
.btn-cta-white:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.25); }
.btn-cta-outline {
    border: 2px solid rgba(255,255,255,0.8); color: var(--white);
    padding: 16px 40px; border-radius: 50px; font-size: 1rem;
    font-family: 'Outfit', sans-serif; font-weight: 600;
    transition: var(--transition); display: inline-flex; align-items: center; gap: 8px;
}
.btn-cta-outline:hover { background: rgba(255,255,255,0.15); transform: translateY(-4px); }

/* ===========================
   RESPONSIVE
=========================== */
@media (max-width: 1024px) {
    .hero-content { grid-template-columns: 1fr; gap: 40px; }
    .hero-visual { display: none; }
    .hero-content { text-align: center; padding: 100px 0; }
    .hero-subtitle { margin: 0 auto 44px; }
    .hero-cta { justify-content: center; }
    .hero-stats { justify-content: center; }
    .brand-intro-grid { grid-template-columns: 1fr; }
    .brand-image-stack { display: none; }
    .why-grid { grid-template-columns: repeat(2, 1fr); }
    .process-timeline { grid-template-columns: repeat(2, 1fr); }
    .process-timeline::before { display: none; }
    .projects-gallery { grid-template-columns: repeat(2, 1fr); }
    .project-item.wide { grid-column: span 2; }
}
@media (max-width: 768px) {
    .hero { min-height: auto; }
    .hero-content { padding: 80px 0; }
    .hero-title { font-size: 2.2rem; }
    .hero-stats { gap: 24px; flex-wrap: wrap; }
    .categories-grid { grid-template-columns: 1fr; }
    .why-grid, .process-timeline { grid-template-columns: 1fr; }
    .projects-gallery { grid-template-columns: 1fr; }
    .project-item.wide { grid-column: span 1; aspect-ratio: 4/3; }
}
</style>
@endsection

@section('content')

<!-- ===== HERO SECTION ===== -->
<section class="hero" id="hero" aria-label="Hero Section">
    <div class="hero-bg-shapes">
        <div class="hero-shape-1"></div>
        <div class="hero-shape-2"></div>
        <div class="hero-grid-overlay"></div>
    </div>
    <div class="container">
        <div class="hero-content">
            <!-- Left: Text -->
            <div class="hero-text">
                <div class="hero-eyebrow" data-aos="fade-up">
                    <span class="hero-eyebrow-dot"></span>
                    Premium Kiosk Manufacturing
                </div>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="100">
                    Engineering Your Vision.<br>
                    Creating <span class="highlight">Extraordinary</span><br>
                    Kiosk Experiences.
                </h1>
                <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="200">
                    From innovative smart kiosks to customized mobile carts and electric vehicles, we transform business ideas into exceptional real-world experiences.
                </p>
                <div class="hero-cta" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('products.index') }}" class="btn btn-primary" id="hero-explore-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Explore Our Products
                    </a>
                    <a href="{{ route('enquiry.create') }}" class="btn btn-outline-white" id="hero-quote-btn">
                        Request a Custom Quote
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>
                <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                    <div class="hero-stat">
                        <div class="hero-stat-num" id="stat-projects">500+</div>
                        <div class="hero-stat-label">Projects Delivered</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num">15+</div>
                        <div class="hero-stat-label">Years Experience</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num">100%</div>
                        <div class="hero-stat-label">Custom Made</div>
                    </div>
                </div>
            </div>

            <!-- Right: Visual (hidden on mobile) -->
            <div class="hero-visual" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-image-frame">
                    <div class="hero-image-main">
                        <img src="{{ asset('images/hero-kiosk.jpg') }}" alt="Premium Kiosk Manufacturing" loading="eager" onerror="this.parentElement.style.background='linear-gradient(135deg,#1A2E45,#1C1C1E)'">
                    </div>
                    <div class="hero-badge">
                        <div class="hero-badge-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div class="hero-badge-text">
                            <strong>ISO Certified</strong>
                            <span>Premium Manufacturing</span>
                        </div>
                    </div>
                    <div class="hero-floating-card">
                        <div class="hero-floating-card-label">New Enquiry</div>
                        <div class="hero-floating-card-val">✓ Received</div>
                        <div class="hero-floating-card-sub">24hr response guarantee</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== BRAND INTRODUCTION ===== -->
<section class="brand-intro" id="brand-intro" aria-label="About Us">
    <div class="container">
        <div class="brand-intro-grid">
            <div data-aos="fade-right">
                <div class="brand-tag">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>
                    Our Story
                </div>
                <h2 class="section-title">Crafting Business Spaces With Precision & Passion</h2>
                <p style="color:var(--text-secondary);margin-bottom:16px;line-height:1.8;">
                    Kovai Kiosk is a leading manufacturer of premium commercial kiosks, mobile push carts, and electric vehicle solutions. Based in Coimbatore, Tamil Nadu, we have been transforming retail and food service environments for over 15 years.
                </p>
                <p style="color:var(--text-secondary);line-height:1.8;">
                    Every product we craft is a combination of engineering excellence, premium materials, and your unique brand identity. From concept to installation, we are your complete manufacturing partner.
                </p>
                <div class="brand-intro-features">
                    <div class="brand-feature">
                        <div class="brand-feature-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="brand-feature-text">
                            <h4>Premium Quality Materials</h4>
                            <p>We use only industrial-grade steel, food-safe stainless steel, and premium wood finishes.</p>
                        </div>
                    </div>
                    <div class="brand-feature">
                        <div class="brand-feature-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
                        </div>
                        <div class="brand-feature-text">
                            <h4>100% Custom Manufacturing</h4>
                            <p>Every kiosk is designed and manufactured to your exact specifications and brand identity.</p>
                        </div>
                    </div>
                    <div class="brand-feature">
                        <div class="brand-feature-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        </div>
                        <div class="brand-feature-text">
                            <h4>End-to-End Service</h4>
                            <p>Design, manufacturing, branding, delivery and professional installation — all under one roof.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="brand-image-stack" data-aos="fade-left">
                <div class="brand-img-main">
                    <img src="{{ asset('images/manufacturing.jpg') }}" alt="Kiosk Manufacturing Facility" loading="lazy" onerror="this.parentElement.style.background='linear-gradient(135deg,#f0ede6,#e8e5df)'">
                </div>
                <div class="brand-img-accent">
                    <img src="{{ asset('images/product2.jpg') }}" alt="Product Detail" loading="lazy" onerror="this.parentElement.style.background='linear-gradient(135deg,#1C1C1E,#0D1B2A)'">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== PRODUCT CATEGORIES ===== -->
<section class="categories-section" id="products" aria-label="Product Categories">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">What We Make</div>
            <h2 class="section-title">Our Product Range</h2>
            <p class="section-subtitle">Discover our comprehensive range of premium kiosk, cart and mobility solutions — each crafted to perfection for your business.</p>
        </div>
        <div class="categories-grid">
            @foreach($featuredCategories as $category)
            <a href="{{ route('products.category', $category->slug) }}" class="category-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                @if($category->image)
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="category-card-img" loading="lazy">
                @else
                    <div class="category-card-placeholder">
                        @if($category->name == 'Smart Kiosk')
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(201,168,76,0.4)" stroke-width="1.5"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                        @elseif($category->name == 'Push Cart')
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(201,168,76,0.4)" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 001.95-1.57l1.65-8.43H6"/></svg>
                        @else
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(201,168,76,0.4)" stroke-width="1.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        @endif
                    </div>
                @endif
                <div class="category-card-content">
                    <div class="category-card-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    </div>
                    <div class="category-card-name">{{ $category->name }}</div>
                    @if($category->description)
                    <div class="category-card-desc">{{ $category->description }}</div>
                    @endif
                    <div class="category-card-link">
                        Explore Products
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== FEATURED PRODUCTS ===== -->
@if($featuredProducts->count() > 0)
<section class="featured-products" id="featured-products" aria-label="Featured Products">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">Our Best</div>
            <h2 class="section-title">Featured Products</h2>
            <p class="section-subtitle">Hand-picked premium products that represent the very best of our manufacturing capability.</p>
        </div>
        <div class="products-grid">
            @foreach($featuredProducts as $product)
            <div class="product-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="product-card-image">
                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" loading="lazy" onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
                    <div class="product-card-badge">Featured</div>
                    <div class="product-card-actions">
                        <a href="{{ route('products.show', [$product->category->slug, $product->slug]) }}" class="btn btn-primary btn-sm">View Details</a>
                        <a href="{{ route('enquiry.create', ['product_id' => $product->id]) }}" class="btn btn-outline btn-sm" style="background:rgba(255,255,255,0.9)">Enquire</a>
                    </div>
                </div>
                <div class="product-card-body">
                    <div class="product-card-cat">{{ optional($product->category)->name }}</div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-desc">{{ $product->short_description }}</p>
                    @if($product->specifications->count() > 0)
                    <div style="display:flex;flex-wrap:wrap;gap:6px">
                        @foreach($product->specifications->take(3) as $spec)
                        <span style="background:var(--ivory-dark);padding:3px 10px;border-radius:20px;font-size:0.73rem;font-family:'Outfit',sans-serif;font-weight:600;color:var(--text-secondary)">{{ $spec->spec_key }}: {{ $spec->spec_value }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center" data-aos="fade-up">
            <a href="{{ route('products.index') }}" class="btn btn-outline" id="view-all-products-btn">
                View All Products
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ===== WHY CHOOSE US ===== -->
<section class="why-us-section" id="why-us" aria-label="Why Choose Us">
    <div class="container" style="position:relative;z-index:1">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">Our Advantage</div>
            <h2 class="section-title">Why Choose Kovai Kiosk?</h2>
            <p class="section-subtitle">We are not just manufacturers — we are your creative and engineering partners for building exceptional commercial spaces.</p>
        </div>
        <div class="why-grid">
            @php
            $reasons = [
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>', 'title' => 'Customized Manufacturing', 'text' => 'Every product is designed from scratch to match your exact brand, dimensions and functional requirements.'],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>', 'title' => 'Premium Quality Materials', 'text' => 'We source only the finest industrial-grade steel, food-safe stainless steel and premium wood composites.'],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>', 'title' => 'Innovative Designs', 'text' => 'Our in-house design team creates stunning contemporary designs that attract customers and build your brand.'],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>', 'title' => 'Professional Installation', 'text' => 'Our expert team handles complete delivery, setup and installation at your chosen location across India.'],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>', 'title' => 'Complete Branding Solutions', 'text' => 'From colour wraps to LED signage, we handle all branding elements to make your kiosk stand out.'],
                ['icon' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg>', 'title' => 'End-to-End Support', 'text' => 'We are with you from initial concept to ongoing after-sales support, ensuring your long-term success.'],
            ];
            @endphp
            @foreach($reasons as $reason)
            <div class="why-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="why-icon">{!! $reason['icon'] !!}</div>
                <h3 class="why-card-title">{{ $reason['title'] }}</h3>
                <p class="why-card-text">{{ $reason['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== MANUFACTURING PROCESS ===== -->
<section class="process-section" id="process" aria-label="Manufacturing Process">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">How We Work</div>
            <h2 class="section-title">Our Manufacturing Process</h2>
            <p class="section-subtitle">A transparent, collaborative process that ensures your kiosk is delivered on time, on spec and exceeds expectations.</p>
        </div>
        <div class="process-timeline">
            @php
            $steps = [
                ['num' => '01', 'title' => 'Understand Client Requirements', 'desc' => 'We start with a detailed consultation to understand your business goals, location, target audience and budget.'],
                ['num' => '02', 'title' => 'Concept & Design', 'desc' => 'Our designers create detailed 3D renderings for your approval before a single piece of metal is cut.'],
                ['num' => '03', 'title' => 'Engineering & Manufacturing', 'desc' => 'Skilled craftsmen bring the approved design to life using premium materials and precision machinery.'],
                ['num' => '04', 'title' => 'Branding & Customization', 'desc' => 'Wraps, signage, lighting and branding elements are applied to give your kiosk its unique identity.'],
                ['num' => '05', 'title' => 'Quality Inspection', 'desc' => 'Every product undergoes a comprehensive 25-point quality inspection before leaving our facility.'],
                ['num' => '06', 'title' => 'Delivery & Installation', 'desc' => 'We handle safe transportation and professional installation at your site, and train your team.'],
            ];
            @endphp
            @foreach($steps as $step)
            <div class="process-step" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="process-num">{{ $step['num'] }}</div>
                <h3 class="process-title">{{ $step['title'] }}</h3>
                <p class="process-desc">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== PROJECTS / PORTFOLIO ===== -->
@if($projects->count() > 0)
<section class="projects-section" id="projects" aria-label="Our Projects">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">Our Work</div>
            <h2 class="section-title">Projects We've Delivered</h2>
            <p class="section-subtitle">A showcase of our finest work — kiosks and carts that have transformed businesses across India.</p>
        </div>
        <div class="projects-gallery">
            @foreach($projects->take(6) as $project)
            <div class="project-item {{ $loop->index === 0 ? 'wide' : '' }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                @if($project->primary_image)
                    <img src="{{ $project->primary_image_url }}" alt="{{ $project->title }}" loading="lazy">
                @else
                    <div class="project-item-placeholder">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="rgba(201,168,76,0.3)" stroke-width="1.5"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    </div>
                @endif
                <div class="project-item-overlay">
                    <div class="project-item-cat">{{ optional($project->category)->name }}</div>
                    <div class="project-item-title">{{ $project->title }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== CTA SECTION ===== -->
<section class="cta-section" id="cta" aria-label="Call to Action">
    <div class="container">
        <div class="cta-content" data-aos="fade-up">
            <h2 class="cta-title">Have a Business Idea?<br>Let's Build Something Extraordinary.</h2>
            <p class="cta-subtitle">Tell us your vision and we'll create the perfect kiosk or cart that brings it to life — professionally, on time and within budget.</p>
            <div class="cta-buttons">
                <a href="{{ route('enquiry.create') }}" class="btn-cta-white" id="cta-quote-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    Get Your Custom Quote
                </a>
                <a href="tel:{{ str_replace([' ', '-'], '', $siteSettings['phone1'] ?? '+919876543210') }}" class="btn-cta-outline" id="cta-call-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.69 10a19.79 19.79 0 01-3.07-8.67A2 2 0 013.6 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 7.91a16 16 0 006 6l1.27-.85a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 15.92z"/></svg>
                    Call Us Now
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
