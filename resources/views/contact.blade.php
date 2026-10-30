@extends('layouts.app')

@section('title', 'Contact Us | Kovai Kiosk')
@section('meta_description', 'Get in touch with Kovai Kiosk for enquiries, quotes, and consultations. Visit us in Coimbatore or contact us by phone, email, or WhatsApp.')

@section('styles')
<style>
.contact-grid {
    display: grid; grid-template-columns: 1fr 1.6fr;
    gap: 60px; align-items: start;
    padding: 80px 0;
}
.contact-info-card {
    background: linear-gradient(160deg, var(--navy), var(--charcoal));
    border-radius: var(--radius-lg); padding: 48px 36px;
    color: white; position: sticky; top: 100px;
}
.contact-info-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem; font-weight: 700; color: white; margin-bottom: 8px;
}
.contact-info-subtitle { color: rgba(255,255,255,0.6); margin-bottom: 40px; font-size: 0.9rem; }
.contact-detail { display: flex; gap: 20px; margin-bottom: 28px; }
.contact-detail-icon {
    width: 48px; height: 48px; border-radius: 12px; flex-shrink: 0;
    background: rgba(201,168,76,0.15); border: 1px solid rgba(201,168,76,0.3);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold-light);
}
.contact-detail-label {
    font-family: 'Outfit', sans-serif; font-size: 0.7rem; font-weight: 700;
    letter-spacing: 2px; text-transform: uppercase; color: var(--gold-light);
    margin-bottom: 4px;
}
.contact-detail-val { color: rgba(255,255,255,0.85); font-size: 0.9rem; line-height: 1.6; }
.contact-detail-val a { color: inherit; transition: color 0.2s; }
.contact-detail-val a:hover { color: var(--gold-light); }

.contact-divider { height: 1px; background: rgba(255,255,255,0.08); margin: 28px 0; }

.whatsapp-btn {
    display: flex; align-items: center; justify-content: center; gap: 12px;
    width: 100%; padding: 16px; border-radius: var(--radius);
    background: #25D366; color: white; font-weight: 700;
    font-family: 'Outfit', sans-serif; font-size: 0.95rem;
    transition: var(--transition); margin-top: 24px;
}
.whatsapp-btn:hover { background: #1fb358; transform: translateY(-3px); color: white; }

/* Form Card */
.contact-form-card {
    background: var(--white); border-radius: var(--radius-lg);
    padding: 48px; box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
}
.contact-form-title { font-size: 2rem; margin-bottom: 8px; }
.contact-form-sub { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 36px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

/* Map */
.map-section { padding: 0 0 80px; }
.map-container {
    border-radius: var(--radius-lg); overflow: hidden;
    box-shadow: var(--shadow-md); height: 400px;
    background: var(--ivory-dark); border: 1px solid var(--border);
}
.map-container iframe { width: 100%; height: 100%; border: none; }

@media (max-width: 768px) {
    .contact-grid { grid-template-columns: 1fr; }
    .contact-info-card { position: static; }
    .form-row { grid-template-columns: 1fr; }
    .contact-form-card { padding: 28px 20px; }
}
</style>
@endsection

@section('content')

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="breadcrumb-sep">›</span>
                <span>Contact Us</span>
            </nav>
            <h1>Get In Touch</h1>
            <p>We'd love to hear about your project. Reach out to us through any of the channels below.</p>
        </div>
    </div>
</section>

<div class="container">
    <div class="contact-grid">
        <!-- Left: Contact Info -->
        <div data-aos="fade-right">
            <div class="contact-info-card">
                <div class="contact-info-title">Contact Information</div>
                <div class="contact-info-subtitle">Reach us by any means that works best for you.</div>

                @if(!empty($siteSettings['phone1']))
                <div class="contact-detail">
                    <div class="contact-detail-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.69 10a19.79 19.79 0 01-3.07-8.67A2 2 0 013.6 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 7.91a16 16 0 006 6l1.27-.85a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 15.92z"/></svg>
                    </div>
                    <div>
                        <div class="contact-detail-label">Phone</div>
                        <div class="contact-detail-val">
                            <a href="tel:{{ str_replace([' ','-'], '', $siteSettings['phone1']) }}">{{ $siteSettings['phone1'] }}</a>
                            @if(!empty($siteSettings['phone2']))
                            <br><a href="tel:{{ str_replace([' ','-'], '', $siteSettings['phone2']) }}">{{ $siteSettings['phone2'] }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @if(!empty($siteSettings['email']))
                <div class="contact-detail">
                    <div class="contact-detail-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div>
                        <div class="contact-detail-label">Email</div>
                        <div class="contact-detail-val"><a href="mailto:{{ $siteSettings['email'] }}">{{ $siteSettings['email'] }}</a></div>
                    </div>
                </div>
                @endif

                @if(!empty($siteSettings['address']))
                <div class="contact-detail">
                    <div class="contact-detail-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <div class="contact-detail-label">Address</div>
                        <div class="contact-detail-val">{{ $siteSettings['address'] }}</div>
                    </div>
                </div>
                @endif

                @if(!empty($siteSettings['business_hours']))
                <div class="contact-detail">
                    <div class="contact-detail-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <div class="contact-detail-label">Business Hours</div>
                        <div class="contact-detail-val">{{ $siteSettings['business_hours'] }}</div>
                    </div>
                </div>
                @endif

                <div class="contact-divider"></div>

                @if(!empty($siteSettings['whatsapp']))
                <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}?text=Hello%2C%20I%20would%20like%20to%20enquire%20about%20your%20kiosk%20products." 
                   class="whatsapp-btn" target="_blank" rel="noopener noreferrer" id="contact-whatsapp-btn">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.555 4.116 1.528 5.85L.057 23.428a.5.5 0 00.515.572l5.736-1.504A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.96 0-3.8-.528-5.383-1.449L4 21l.483-2.497A9.956 9.956 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                    Chat on WhatsApp
                </a>
                @endif
            </div>
        </div>

        <!-- Right: Enquiry Form -->
        <div data-aos="fade-left">
            <div class="contact-form-card">
                <h2 class="contact-form-title">Send Us a Message</h2>
                <p class="contact-form-sub">Fill out the form below and we will get back to you within 24 hours.</p>

                @if(session('success'))
                    <div class="flash-message flash-success">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('enquiry.store') }}" method="POST" enctype="multipart/form-data" id="contact-enquiry-form">
                    @csrf
                    <input type="hidden" name="source" value="contact">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="full_name">Full Name <span class="req">*</span></label>
                            <input type="text" id="full_name" name="full_name" class="form-control @error('full_name') error @enderror" value="{{ old('full_name') }}" required placeholder="Your full name">
                            @error('full_name')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="company_name">Company Name</label>
                            <input type="text" id="company_name" name="company_name" class="form-control" value="{{ old('company_name') }}" placeholder="Company (optional)">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="mobile_number">Mobile Number <span class="req">*</span></label>
                            <input type="tel" id="mobile_number" name="mobile_number" class="form-control @error('mobile_number') error @enderror" value="{{ old('mobile_number') }}" required placeholder="+91 98765 43210">
                            @error('mobile_number')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="message">Your Message</label>
                        <textarea id="message" name="message" class="form-control" placeholder="Tell us about your requirements..." rows="5">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center" id="contact-form-submit">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Google Maps -->
<section class="map-section">
    <div class="container" data-aos="fade-up">
        <div class="map-container">
            @if(!empty($siteSettings['google_maps_url']) && strpos($siteSettings['google_maps_url'], 'embed') !== false)
                <iframe src="{{ $siteSettings['google_maps_url'] }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Kovai Kiosk Location"></iframe>
            @else
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125327.45059024393!2d76.89398!3d11.01168!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba859af2f971cb5%3A0x2fc1c81e183ed282!2sCoimbatore%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1698000000000" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Kovai Kiosk Location Map"></iframe>
            @endif
        </div>
    </div>
</section>

@endsection
