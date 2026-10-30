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
