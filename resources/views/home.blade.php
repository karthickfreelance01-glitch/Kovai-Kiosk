@extends('layouts.app')

@section('title', ($siteSettings['meta_title'] ?? 'Pathy Display Racks | Kovai Kiosk - Premium Kiosk & Display Manufacturers'))

@section('styles')
<style>
/* ==========================================================================
   HERO SECTION - CLEAN, MODERN & MINIMAL (pdr Brand Language)
   ========================================================================== */
.hero {
    position: relative;
    min-height: 90vh;
    display: flex;
    align-items: center;
    background: #2D3136;
    overflow: hidden;
}

.hero-bg-shapes {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.hero-shape-1 {
    position: absolute;
    width: 620px;
    height: 620px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(141, 198, 63, 0.14) 0%, transparent 70%);
    top: -180px;
    right: -100px;
    animation: pulse-slow 8s ease-in-out infinite;
}

.hero-shape-2 {
    position: absolute;
    width: 440px;
    height: 440px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(141, 198, 63, 0.08) 0%, transparent 70%);
    bottom: -100px;
    left: -60px;
    animation: pulse-slow 10s ease-in-out infinite reverse;
}

.hero-grid-overlay {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
    background-size: 50px 50px;
}

@keyframes pulse-slow {
    0%, 100% { transform: scale(1) translate(0, 0); }
    50% { transform: scale(1.08) translate(15px, -15px); }
}

.hero-content {
    position: relative;
    z-index: 2;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 70px;
    align-items: center;
    padding: 80px 0;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(141, 198, 63, 0.15);
    border: 1px solid rgba(141, 198, 63, 0.35);
    border-radius: var(--radius-pill);
    padding: 7px 20px;
    font-family: var(--font-heading);
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--brand-green);
    margin-bottom: 24px;
}

.hero-eyebrow-dot {
    width: 7px;
    height: 7px;
    background: var(--brand-green);
    border-radius: 50%;
    animation: blink 2s ease-in-out infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

.hero-title {
    font-family: var(--font-heading);
    font-size: clamp(2.3rem, 4.8vw, 3.8rem);
    font-weight: 800;
    line-height: 1.15;
    color: #FFFFFF;
    margin-bottom: 20px;
    letter-spacing: -0.5px;
}

.hero-title .highlight {
    color: var(--brand-green) !important;
}

.hero-subtitle {
    font-family: var(--font-body);
    font-size: 1.05rem;
    line-height: 1.75;
    color: rgba(255, 255, 255, 0.75);
    margin-bottom: 38px;
    max-width: 520px;
}

.hero-cta {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 48px;
}

.hero-stats {
    display: flex;
    gap: 36px;
    padding-top: 32px;
    border-top: 1px solid rgba(255, 255, 255, 0.12);
}

.hero-stat-num {
    font-family: var(--font-heading);
    font-size: 2rem;
    font-weight: 800;
    color: var(--brand-green);
    line-height: 1.1;
}

.hero-stat-label {
    font-family: var(--font-heading);
    font-size: 0.78rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.6);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 4px;
}

/* ==========================================================================
   HERO 3D SLIDER STAGE
   ========================================================================== */
.hero-visual {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    perspective: 1200px;
}

.hero-slider-wrap {
    position: relative;
    width: 100%;
    max-width: 520px;
}

.hero-slider-floating {
    position: relative;
    width: 100%;
    transform-style: preserve-3d;
    animation: heroFloat3D 6.5s ease-in-out infinite;
    transition: transform 0.25s cubic-bezier(0.2, 0, 0.2, 1);
}

@keyframes heroFloat3D {
    0%, 100% {
        transform: translateY(0px) rotateY(0deg) rotateX(0deg);
    }
    50% {
        transform: translateY(-10px) rotateY(-2deg) rotateX(1deg);
    }
}

.hero-slider-glow {
    position: absolute;
    inset: -20px;
    border-radius: 36px;
    background: radial-gradient(circle at 60% 40%, rgba(141, 198, 63, 0.25) 0%, rgba(45, 49, 54, 0.4) 50%, transparent 75%);
    filter: blur(20px);
    z-index: 0;
    pointer-events: none;
}

.hero-slider-viewport {
    position: relative;
    width: 100%;
    aspect-ratio: 4/5;
    border-radius: var(--radius-xl);
    overflow: hidden;
    background: #1E2125;
    border: 1.5px solid rgba(141, 198, 63, 0.35);
    box-shadow:
        0 24px 60px rgba(0, 0, 0, 0.5),
        0 0 25px rgba(141, 198, 63, 0.15);
    z-index: 1;
    touch-action: pan-y;
    user-select: none;
}

/* Slide Cards */
.hero-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: scale(0.95) translateX(20px);
    transition:
        opacity 0.65s cubic-bezier(0.4, 0, 0.2, 1),
        transform 0.65s cubic-bezier(0.4, 0, 0.2, 1),
        visibility 0.65s;
    overflow: hidden;
}

.hero-slide.active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: scale(1) translateX(0);
    z-index: 2;
}

.hero-slide.prev-slide {
    opacity: 0;
    transform: scale(1.03) translateX(-20px);
    z-index: 1;
}

.hero-slide-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transform: scale(1);
    transition: transform 6s cubic-bezier(0.25, 1, 0.5, 1);
    will-change: transform;
}

.hero-slide.active .hero-slide-img {
    transform: scale(1.06);
}

.hero-slide-gradient {
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0.05) 0%,
        rgba(0, 0, 0, 0.2) 40%,
        rgba(0, 0, 0, 0.75) 75%,
        rgba(0, 0, 0, 0.92) 100%
    );
    z-index: 2;
}

.hero-slide-flare {
    position: absolute;
    top: -40px;
    right: -40px;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    pointer-events: none;
    background: radial-gradient(circle, rgba(141, 198, 63, 0.2) 0%, transparent 70%);
    z-index: 2;
}

.hero-slide-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 24px 26px 36px;
    z-index: 4;
    display: flex;
    flex-direction: column;
    gap: 8px;
    pointer-events: auto;
}

.hero-slide-category {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 5px 14px;
    border-radius: var(--radius-pill);
    font-family: var(--font-heading);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    width: fit-content;
    background: rgba(141, 198, 63, 0.2);
    border: 1px solid rgba(141, 198, 63, 0.45);
    color: var(--brand-green);
    backdrop-filter: blur(8px);
    transform: translateY(10px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.2, 0, 0.2, 1) 0.15s;
}

.hero-slide.active .hero-slide-category {
    transform: translateY(0);
    opacity: 1;
}

.hero-slide-title {
    font-family: var(--font-heading);
    font-size: 1.45rem;
    font-weight: 700;
    color: #FFFFFF;
    line-height: 1.25;
    margin: 0;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
    transform: translateY(12px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.2, 0, 0.2, 1) 0.25s;
}

.hero-slide.active .hero-slide-title {
    transform: translateY(0);
    opacity: 1;
}

.hero-slide-subtitle {
    font-family: var(--font-heading);
    font-size: 0.85rem;
    color: var(--brand-green-light);
    font-weight: 500;
    letter-spacing: 0.3px;
    margin: 0;
    transform: translateY(12px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.2, 0, 0.2, 1) 0.35s;
}

.hero-slide.active .hero-slide-subtitle {
    transform: translateY(0);
    opacity: 1;
}

.hero-slide-desc {
    font-size: 0.82rem;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.55;
    margin: 0;
    transform: translateY(12px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.2, 0, 0.2, 1) 0.35s;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.hero-slide.active .hero-slide-desc {
    transform: translateY(0);
    opacity: 1;
}

.hero-slide-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-top: 4px;
    padding: 7px 18px;
    border-radius: var(--radius-pill);
    font-family: var(--font-heading);
    font-size: 0.8rem;
    font-weight: 700;
    color: #FFFFFF;
    background: var(--brand-green);
    border: none;
    width: fit-content;
    box-shadow: 0 4px 12px rgba(141, 198, 63, 0.35);
    transform: translateY(12px);
    opacity: 0;
    transition: transform 0.4s cubic-bezier(0.2, 0, 0.2, 1) 0.45s, opacity 0.4s ease 0.45s, background 0.2s;
}

.hero-slide.active .hero-slide-btn {
    transform: translateY(0);
    opacity: 1;
}

.hero-slide-btn:hover {
    background: var(--brand-green-dark);
    transform: translateY(-2px);
    color: #FFFFFF;
}

/* Slider Navigation Buttons */
.hero-slider-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(30, 33, 37, 0.85);
    border: 1px solid rgba(141, 198, 63, 0.4);
    color: var(--brand-green);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    cursor: pointer;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    transition: var(--transition);
}

.hero-slider-prev { left: 14px; }
.hero-slider-next { right: 14px; }

.hero-slider-nav-btn:hover {
    background: var(--brand-green);
    color: #FFFFFF;
    border-color: var(--brand-green);
    transform: translateY(-50%) scale(1.08);
}

.hero-slider-dots {
    position: absolute;
    bottom: 12px;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    z-index: 10;
}

.hero-slider-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.35);
    border: 1px solid rgba(255, 255, 255, 0.2);
    cursor: pointer;
    transition: var(--transition);
    padding: 0;
}

.hero-slider-dot.active {
    width: 24px;
    border-radius: var(--radius-pill);
    background: var(--brand-green);
    border-color: var(--brand-green);
}

/* Fallback Design */
.hero-fallback-backdrop {
    width: 100%;
    height: 100%;
    background: #1E2125;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.hero-fallback-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(141, 198, 63, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(141, 198, 63, 0.05) 1px, transparent 1px);
    background-size: 30px 30px;
}

.hero-fallback-icon-wrap {
    width: 84px;
    height: 84px;
    border-radius: var(--radius-lg);
    background: rgba(141, 198, 63, 0.15);
    border: 1px solid rgba(141, 198, 63, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

/* Floating Quality Badges */
.hero-badge {
    position: absolute;
    bottom: -16px;
    left: -16px;
    background: #FFFFFF;
    border-radius: var(--radius-lg);
    padding: 12px 18px;
    box-shadow: var(--shadow-lg);
    display: flex;
    gap: 12px;
    align-items: center;
    min-width: 190px;
    z-index: 12;
    animation: badgeFloat 5.5s ease-in-out infinite;
    border: 1px solid var(--border);
}

@keyframes badgeFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.hero-badge-icon {
    width: 42px;
    height: 42px;
    background: var(--brand-green);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #FFFFFF;
}

.hero-badge-text strong {
    display: block;
    font-family: var(--font-heading);
    font-size: 0.92rem;
    font-weight: 700;
    color: var(--brand-grey-dark);
}

.hero-badge-text span {
    font-family: var(--font-body);
    font-size: 0.74rem;
    color: var(--text-muted);
}

.hero-floating-card {
    position: absolute;
    top: 24px;
    right: -24px;
    background: rgba(30, 33, 37, 0.9);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(141, 198, 63, 0.4);
    border-radius: var(--radius-lg);
    padding: 14px 18px;
    color: #FFFFFF;
    min-width: 170px;
    z-index: 12;
    box-shadow: var(--shadow-lg);
    animation: badgeFloatReverse 6.5s ease-in-out infinite;
}

@keyframes badgeFloatReverse {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(8px); }
}

.hero-floating-card-label {
    font-family: var(--font-heading);
    font-size: 0.7rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--brand-green);
    margin-bottom: 4px;
    font-weight: 600;
}

.hero-floating-card-val {
    font-family: var(--font-heading);
    font-size: 1.3rem;
    font-weight: 700;
    color: #FFFFFF;
}

.hero-floating-card-sub {
    font-size: 0.72rem;
    color: rgba(255, 255, 255, 0.65);
}

/* ==========================================================================
   BRAND INTRO SECTION (Light-Grey #F7F8F5)
   ========================================================================== */
.brand-intro {
    background: var(--bg-alt);
    padding: 90px 0;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}

.brand-intro-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 70px;
    align-items: center;
}

.brand-tag {
    display: inline-flex;
    gap: 8px;
    align-items: center;
    background: var(--brand-green-light);
    border: 1px solid rgba(141, 198, 63, 0.35);
    border-radius: var(--radius-pill);
    padding: 5px 16px;
    font-family: var(--font-heading);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--brand-green-dark);
    margin-bottom: 18px;
}

.brand-intro-features {
    margin-top: 32px;
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.brand-feature {
    display: flex;
    gap: 16px;
    align-items: flex-start;
}

.brand-feature-icon {
    width: 44px;
    height: 44px;
    flex-shrink: 0;
    background: var(--brand-green);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    margin-top: 2px;
}

.brand-feature-text h4 {
    font-family: var(--font-heading);
    font-size: 0.98rem;
    font-weight: 700;
    color: var(--brand-grey-dark);
    margin-bottom: 4px;
}

.brand-feature-text p {
    font-family: var(--font-body);
    font-size: 0.88rem;
    color: var(--text-secondary);
    line-height: 1.6;
}

.brand-image-stack {
    position: relative;
}

.brand-img-main {
    width: 88%;
    aspect-ratio: 4/3;
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border);
}

.brand-img-main img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.brand-img-accent {
    position: absolute;
    bottom: -24px;
    right: 0;
    width: 48%;
    aspect-ratio: 1;
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    border: 4px solid #FFFFFF;
}

.brand-img-accent img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ==========================================================================
   PRODUCT CATEGORIES SECTION (White #FFFFFF)
   ========================================================================== */
.categories-section {
    padding: 90px 0;
    background: var(--bg);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 28px;
    margin-top: 24px;
}

.category-card {
    position: relative;
    border-radius: var(--radius-xl);
    overflow: hidden;
    aspect-ratio: 4/3;
    cursor: pointer;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
    transition: var(--transition);
}

.category-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--brand-green);
}

.category-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.82) 0%, rgba(0, 0, 0, 0.2) 60%, transparent 100%);
    z-index: 1;
    transition: opacity 0.3s;
}

.category-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.category-card:hover .category-card-img {
    transform: scale(1.06);
}

.category-card-placeholder {
    width: 100%;
    height: 100%;
    background: #2D3136;
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-card-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 2;
    padding: 26px;
    transform: translateY(16px);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.category-card:hover .category-card-content {
    transform: translateY(0);
}

.category-card-icon {
    width: 44px;
    height: 44px;
    background: var(--brand-green);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    margin-bottom: 12px;
}

.category-card-name {
    font-family: var(--font-heading);
    font-size: 1.4rem;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 6px;
}

.category-card-desc {
    font-size: 0.85rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 14px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.category-card:hover .category-card-desc {
    max-height: 60px;
}

.category-card-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font-heading);
    font-size: 0.84rem;
    font-weight: 700;
    color: var(--brand-green);
}

/* ==========================================================================
   FEATURED PRODUCTS (Light-Grey #F7F8F5)
   ========================================================================== */
.featured-products {
    padding: 90px 0;
    background: var(--bg-alt);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 28px;
    margin-bottom: 44px;
}

/* ==========================================================================
   WHY CHOOSE US (Dark Grey #4A4A4A with Green Accents)
   ========================================================================== */
.why-us-section {
    padding: 90px 0;
    background: var(--brand-grey-dark);
    position: relative;
    overflow: hidden;
}

.why-us-section .section-label {
    color: var(--brand-green);
}

.why-us-section .section-label::before,
.why-us-section .section-label::after {
    background: var(--brand-green);
}

.why-us-section .section-title {
    color: #FFFFFF;
}

.why-us-section .section-subtitle {
    color: rgba(255, 255, 255, 0.7);
}

.why-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    position: relative;
    z-index: 1;
}

.why-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: var(--radius-lg);
    padding: 34px 26px;
    transition: var(--transition);
}

.why-card:hover {
    background: rgba(255, 255, 255, 0.08);
    border-color: var(--brand-green);
    transform: translateY(-4px);
}

.why-icon {
    width: 54px;
    height: 54px;
    background: var(--brand-green);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    margin-bottom: 20px;
}

.why-card-title {
    font-family: var(--font-heading);
    font-size: 1.05rem;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 8px;
}

.why-card-text {
    font-size: 0.88rem;
    color: rgba(255, 255, 255, 0.65);
    line-height: 1.65;
}

/* ==========================================================================
   PROCESS SECTION (White #FFFFFF)
   ========================================================================== */
.process-section {
    padding: 90px 0;
    background: var(--bg);
}

.process-timeline {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
    position: relative;
    margin-top: 30px;
}

.process-step {
    padding: 30px 24px;
    text-align: center;
    position: relative;
    background: var(--bg-alt);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
    transition: var(--transition);
}

.process-step:hover {
    border-color: var(--brand-green);
    transform: translateY(-4px);
    box-shadow: var(--shadow-sm);
}

.process-num {
    width: 64px;
    height: 64px;
    border: 2px solid var(--brand-green);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-heading);
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--brand-green);
    margin: 0 auto 18px;
    background: #FFFFFF;
    transition: var(--transition);
}

.process-step:hover .process-num {
    background: var(--brand-green);
    color: #FFFFFF;
    transform: scale(1.08);
}

.process-title {
    font-family: var(--font-heading);
    font-size: 1.02rem;
    font-weight: 700;
    color: var(--brand-grey-dark);
    margin-bottom: 8px;
}

.process-desc {
    font-size: 0.85rem;
    color: var(--text-secondary);
    line-height: 1.65;
}

/* ==========================================================================
   PROJECTS SECTION (Light-Grey #F7F8F5)
   ========================================================================== */
.projects-section {
    padding: 90px 0;
    background: var(--bg-alt);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}

.projects-gallery {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.project-item {
    position: relative;
    border-radius: var(--radius-lg);
    overflow: hidden;
    aspect-ratio: 3/4;
    cursor: pointer;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
}

.project-item.wide {
    grid-column: span 2;
    aspect-ratio: 16/9;
}

.project-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.project-item:hover img {
    transform: scale(1.06);
}

.project-item-placeholder {
    width: 100%;
    height: 100%;
    background: #2D3136;
    display: flex;
    align-items: center;
    justify-content: center;
}

.project-item::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.75) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.3s;
}

.project-item:hover::after {
    opacity: 1;
}

.project-item-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 2;
    padding: 20px;
    transform: translateY(100%);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.project-item:hover .project-item-overlay {
    transform: translateY(0);
}

.project-item-cat {
    font-family: var(--font-heading);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    color: var(--brand-green);
    margin-bottom: 4px;
}

.project-item-title {
    font-family: var(--font-heading);
    font-size: 0.95rem;
    font-weight: 700;
    color: #FFFFFF;
}

/* ==========================================================================
   CTA SECTION (Solid Brand Lime Green #8DC63F)
   ========================================================================== */
.cta-section {
    padding: 85px 0;
    background: var(--brand-green);
    position: relative;
    overflow: hidden;
}

.cta-content {
    position: relative;
    z-index: 1;
    text-align: center;
}

.cta-title {
    font-family: var(--font-heading);
    font-size: clamp(1.9rem, 3.8vw, 2.8rem);
    font-weight: 800;
    color: #FFFFFF;
    margin-bottom: 14px;
    letter-spacing: -0.5px;
}

.cta-subtitle {
    font-family: var(--font-body);
    font-size: 1.05rem;
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 36px;
    max-width: 680px;
    margin-left: auto;
    margin-right: auto;
}

.cta-buttons {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-cta-white {
    background: #FFFFFF;
    color: var(--brand-green-dark);
    font-family: var(--font-heading);
    font-weight: 700;
    padding: 14px 34px;
    border-radius: var(--radius-pill);
    font-size: 0.95rem;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
}

.btn-cta-white:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
    background: #FDFDFD;
    color: var(--brand-grey-dark);
}

.btn-cta-outline {
    border: 2px solid #FFFFFF;
    color: #FFFFFF;
    padding: 14px 34px;
    border-radius: var(--radius-pill);
    font-size: 0.95rem;
    font-family: var(--font-heading);
    font-weight: 700;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
}

.btn-cta-outline:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
    color: #FFFFFF;
}

/* ==========================================================================
   RESPONSIVE OVERRIDES
   ========================================================================== */
@media (max-width: 1024px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 48px;
        text-align: center;
        padding: 80px 0 50px;
    }
    .hero-visual {
        display: flex;
        justify-content: center;
        width: 100%;
        margin: 0 auto;
    }
    .hero-slider-wrap { max-width: 480px; }
    .hero-floating-card { right: -10px; top: -10px; }
    .hero-badge { left: -10px; bottom: -12px; }
    .hero-subtitle { margin: 0 auto 38px; }
    .hero-cta { justify-content: center; }
    .hero-stats { justify-content: center; }
    .brand-intro-grid { grid-template-columns: 1fr; }
    .brand-image-stack { display: none; }
    .why-grid { grid-template-columns: repeat(2, 1fr); }
    .process-timeline { grid-template-columns: repeat(2, 1fr); }
    .projects-gallery { grid-template-columns: repeat(2, 1fr); }
    .project-item.wide { grid-column: span 2; }
}

@media (max-width: 768px) {
    .hero { min-height: auto; }
    .hero-content { padding: 60px 0 40px; gap: 32px; }
    .hero-title { font-size: 2.1rem; }
    .hero-stats { gap: 20px; flex-wrap: wrap; }
    .hero-slider-viewport { aspect-ratio: 16/12; min-height: 300px; }
    .hero-slide-title { font-size: 1.2rem; }
    .hero-slide-subtitle { font-size: 0.76rem; }
    .hero-slide-content { padding: 16px 18px 24px; }
    .hero-slider-nav-btn { width: 34px; height: 34px; }
    .hero-floating-card, .hero-badge { display: none; }
    .categories-grid { grid-template-columns: 1fr; }
    .why-grid, .process-timeline { grid-template-columns: 1fr; }
    .projects-gallery { grid-template-columns: 1fr; }
    .project-item.wide { grid-column: span 1; aspect-ratio: 4/3; }
}

/* Reduced Motion Accessibility */
@media (prefers-reduced-motion: reduce) {
    .hero-slider-floating,
    .hero-badge,
    .hero-floating-card,
    .hero-shape-1,
    .hero-shape-2 {
        animation: none !important;
        transform: none !important;
    }
    .hero-slide,
    .hero-slide-img,
    .hero-slide-category,
    .hero-slide-title,
    .hero-slide-subtitle,
    .hero-slide-desc,
    .hero-slide-btn {
        transition-duration: 0.01ms !important;
    }
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
                    Premium Kiosk & Display Manufacturing
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
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Explore Our Products
                    </a>
                    <a href="{{ route('enquiry.create') }}" class="btn btn-outline-white" id="hero-quote-btn">
                        Request a Custom Quote
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
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

            <!-- Right: Premium Animated Hero Slider -->
            <div class="hero-visual" data-aos="fade-left" data-aos-delay="200">
                <div class="hero-slider-wrap" id="hero-slider-container">
                    <!-- 3D Floating Stage -->
                    <div class="hero-slider-floating" id="hero-slider-floating">
                        <!-- Ambient Backdrop Glow -->
                        <div class="hero-slider-glow"></div>

                        <!-- Viewport / Frame -->
                        <div class="hero-slider-viewport" id="hero-slider-viewport" role="region" aria-label="Featured Products Slider" aria-roledescription="carousel">
                            @if(isset($heroSliders) && $heroSliders->isNotEmpty())
                                @foreach($heroSliders as $index => $slide)
                                <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-slide-index="{{ $index }}" role="group" aria-roledescription="slide" aria-label="{{ $slide->title }}">
                                    <!-- Image with Eager Loading on first slide, Lazy on remainder -->
                                    <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="hero-slide-img" {{ $index === 0 ? 'loading=eager fetchpriority=high' : 'loading=lazy' }} onerror="this.onerror=null;this.parentElement.style.background='#2D3136'">

                                    <!-- Atmospheric Overlays -->
                                    <div class="hero-slide-gradient"></div>
                                    <div class="hero-slide-flare"></div>

                                    <!-- Slide Caption Content -->
                                    <div class="hero-slide-content">
                                        @if($slide->category)
                                            <div class="hero-slide-category">
                                                @if(stripos($slide->category, 'kiosk') !== false)
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                                @elseif(stripos($slide->category, 'cart') !== false)
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                                @elseif(stripos($slide->category, 'ev') !== false || stripos($slide->category, 'vehicle') !== false)
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                                @else
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/></svg>
                                                @endif
                                                <span>{{ $slide->category }}</span>
                                            </div>
                                        @endif

                                        <h3 class="hero-slide-title">{{ $slide->title }}</h3>

                                        @if($slide->subtitle)
                                            <div class="hero-slide-subtitle">{{ $slide->subtitle }}</div>
                                        @elseif($slide->description)
                                            <p class="hero-slide-desc">{{ Str::limit($slide->description, 90) }}</p>
                                        @endif

                                        @if($slide->button_text)
                                            <a href="{{ $slide->button_url ?? route('products.index') }}" class="hero-slide-btn">
                                                <span>{{ $slide->button_text }}</span>
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                @endforeach

                                <!-- Navigation Buttons -->
                                @if($heroSliders->count() > 1)
                                <button type="button" class="hero-slider-nav-btn hero-slider-prev" id="hero-slider-prev-btn" aria-label="Previous Slide">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                                </button>
                                <button type="button" class="hero-slider-nav-btn hero-slider-next" id="hero-slider-next-btn" aria-label="Next Slide">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                                </button>

                                <!-- Pagination Dots -->
                                <div class="hero-slider-dots" id="hero-slider-dots" role="tablist" aria-label="Slider Pagination">
                                    @foreach($heroSliders as $index => $slide)
                                    <button type="button" class="hero-slider-dot {{ $index === 0 ? 'active' : '' }}" data-dot-index="{{ $index }}" role="tab" aria-selected="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Go to slide {{ $index + 1 }}"></button>
                                    @endforeach
                                </div>
                                @endif
                            @else
                                <!-- Graceful Fallback Showcase Card if no slides exist -->
                                <div class="hero-slide active fallback-slide">
                                    <div class="hero-fallback-backdrop">
                                        <div class="hero-fallback-grid"></div>
                                        <div class="hero-fallback-icon-wrap">
                                            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="var(--brand-green)" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/><circle cx="12" cy="10" r="3"/></svg>
                                        </div>
                                        <div class="hero-slide-content">
                                            <div class="hero-slide-category">
                                                <span>Custom Manufacturing</span>
                                            </div>
                                            <h3 class="hero-slide-title">Precision Kiosks & Display Racks</h3>
                                            <p class="hero-slide-desc">Smart interactive displays, food push carts, and commercial display systems manufactured by Pathy Display Racks.</p>
                                            <a href="{{ route('products.index') }}" class="hero-slide-btn">
                                                <span>Explore Catalogue</span>
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Floating Quality Badges -->
                        <div class="hero-badge">
                            <div class="hero-badge-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <div class="hero-badge-text">
                                <strong>ISO Certified</strong>
                                <span>Premium Manufacturing</span>
                            </div>
                        </div>

                        <div class="hero-floating-card">
                            <div class="hero-floating-card-label">Engineering Vision</div>
                            <div class="hero-floating-card-val">100% Custom</div>
                            <div class="hero-floating-card-sub">Smart Kiosk • Push Cart • EV</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== BRAND INTRODUCTION (Light Grey #F7F8F5) ===== -->
<section class="brand-intro" id="brand-intro" aria-label="About Us">
    <div class="container">
        <div class="brand-intro-grid">
            <div data-aos="fade-right">
                <div class="brand-tag">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>
                    Our Story
                </div>
                <h2 class="section-title">Crafting Business Spaces With <span class="highlight">Precision & Passion</span></h2>
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
                    <img src="{{ asset('images/manufacturing.jpg') }}" alt="Kiosk Manufacturing Facility" loading="lazy" onerror="this.parentElement.style.background='var(--bg-alt)'">
                </div>
                <div class="brand-img-accent">
                    <img src="{{ asset('images/product2.jpg') }}" alt="Product Detail" loading="lazy" onerror="this.parentElement.style.background='#2D3136'">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== PRODUCT CATEGORIES (White #FFFFFF) ===== -->
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
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(141,198,63,0.5)" stroke-width="1.8"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                        @elseif($category->name == 'Push Cart')
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(141,198,63,0.5)" stroke-width="1.8"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 001.95-1.57l1.65-8.43H6"/></svg>
                        @else
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(141,198,63,0.5)" stroke-width="1.8"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
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
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== FEATURED PRODUCTS (Light Grey #F7F8F5) ===== -->
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
                        <a href="{{ route('enquiry.create', ['product_id' => $product->id]) }}" class="btn btn-outline btn-sm" style="background:#FFFFFF;color:var(--brand-green-dark)">Enquire</a>
                    </div>
                </div>
                <div class="product-card-body">
                    <div class="product-card-cat">{{ optional($product->category)->name }}</div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-desc">{{ $product->short_description }}</p>
                    @if($product->specifications->count() > 0)
                    <div style="display:flex;flex-wrap:wrap;gap:6px">
                        @foreach($product->specifications->take(3) as $spec)
                        <span style="background:var(--bg-alt);border:1px solid var(--border);padding:3px 10px;border-radius:20px;font-size:0.73rem;font-family:var(--font-heading);font-weight:600;color:var(--text-secondary)">{{ $spec->spec_key }}: {{ $spec->spec_value }}</span>
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
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>
@endif

<!-- ===== WHY CHOOSE US (Dark Grey #4A4A4A) ===== -->
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
                ['icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>', 'title' => 'Customized Manufacturing', 'text' => 'Every product is designed from scratch to match your exact brand, dimensions and functional requirements.'],
                ['icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>', 'title' => 'Premium Quality Materials', 'text' => 'We source only the finest industrial-grade steel, food-safe stainless steel and premium wood composites.'],
                ['icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>', 'title' => 'Innovative Designs', 'text' => 'Our in-house design team creates stunning contemporary designs that attract customers and build your brand.'],
                ['icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>', 'title' => 'Professional Installation', 'text' => 'Our expert team handles complete delivery, setup and installation at your chosen location across India.'],
                ['icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>', 'title' => 'Complete Branding Solutions', 'text' => 'From colour wraps to LED signage, we handle all branding elements to make your kiosk stand out.'],
                ['icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg>', 'title' => 'End-to-End Support', 'text' => 'We are with you from initial concept to ongoing after-sales support, ensuring your long-term success.'],
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

<!-- ===== MANUFACTURING PROCESS (White #FFFFFF) ===== -->
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

<!-- ===== PROJECTS / PORTFOLIO (Light Grey #F7F8F5) ===== -->
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
                @if($project->has_image)
                    <img src="{{ $project->primary_image_url }}" alt="{{ $project->title }}" loading="lazy" onerror="this.style.display='none';if(this.nextElementSibling){this.nextElementSibling.style.display='flex';}">
                    <div class="project-item-placeholder" style="display:none">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="rgba(141,198,63,0.4)" stroke-width="1.8"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                    </div>
                @else
                    <div class="project-item-placeholder">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="rgba(141,198,63,0.4)" stroke-width="1.8"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
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

<!-- ===== CTA SECTION (Solid Brand Green #8DC63F) ===== -->
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sliderContainer = document.getElementById('hero-slider-container');
    const viewport = document.getElementById('hero-slider-viewport');
    const floatingStage = document.getElementById('hero-slider-floating');
    if (!viewport) return;

    const slides = Array.from(viewport.querySelectorAll('.hero-slide'));
    const prevBtn = document.getElementById('hero-slider-prev-btn');
    const nextBtn = document.getElementById('hero-slider-next-btn');
    const dotsContainer = document.getElementById('hero-slider-dots');
    const dots = dotsContainer ? Array.from(dotsContainer.querySelectorAll('.hero-slider-dot')) : [];

    const totalSlides = slides.length;
    if (totalSlides <= 1) return;

    let currentIndex = 0;
    let isTransitioning = false;
    let autoSlideInterval = 5200;
    let autoSlideTimer = null;
    let isPaused = false;

    function goToSlide(targetIndex, direction = 'next') {
        if (isTransitioning || targetIndex === currentIndex) return;
        isTransitioning = true;

        const currentSlide = slides[currentIndex];
        const targetSlide = slides[targetIndex];

        slides.forEach(s => s.classList.remove('prev-slide'));
        currentSlide.classList.add('prev-slide');
        currentSlide.classList.remove('active');

        targetSlide.classList.add('active');

        if (dots.length > 0) {
            dots.forEach((dot, idx) => {
                const isActive = idx === targetIndex;
                dot.classList.toggle('active', isActive);
                dot.setAttribute('aria-selected', isActive ? 'true' : 'false');
            });
        }

        currentIndex = targetIndex;

        setTimeout(() => {
            currentSlide.classList.remove('prev-slide');
            isTransitioning = false;
        }, 750);
    }

    function nextSlide() {
        const next = (currentIndex + 1) % totalSlides;
        goToSlide(next, 'next');
    }

    function prevSlide() {
        const prev = (currentIndex - 1 + totalSlides) % totalSlides;
        goToSlide(prev, 'prev');
    }

    if (nextBtn) nextBtn.addEventListener('click', () => { resetAutoPlay(); nextSlide(); });
    if (prevBtn) prevBtn.addEventListener('click', () => { resetAutoPlay(); prevSlide(); });

    dots.forEach((dot, idx) => {
        dot.addEventListener('click', () => {
            resetAutoPlay();
            goToSlide(idx);
        });
    });

    function startAutoPlay() {
        if (autoSlideTimer) clearInterval(autoSlideTimer);
        autoSlideTimer = setInterval(() => {
            if (!isPaused) nextSlide();
        }, autoSlideInterval);
    }

    function resetAutoPlay() {
        clearInterval(autoSlideTimer);
        startAutoPlay();
    }

    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', () => { isPaused = true; });
        sliderContainer.addEventListener('mouseleave', () => { isPaused = false; });
    }

    startAutoPlay();
});
</script>
@endsection
