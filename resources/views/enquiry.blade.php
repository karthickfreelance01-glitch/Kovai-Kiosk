@extends('layouts.app')

@section('title', 'Enquiry Form | Pathy Display Racks & Kovai Kiosk')
@section('meta_description', 'Submit your enquiry to Pathy Display Racks & Kovai Kiosk. Tell us about your display rack, kiosk, cart or EV vehicle requirements and get a custom quote.')

@section('styles')
<style>
.enquiry-wrapper {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 48px;
    padding: 75px 0;
}
.enquiry-sidebar {
    position: sticky;
    top: 100px;
}
.enquiry-info {
    background: var(--brand-grey-dark);
    border-radius: var(--radius-xl);
    padding: 36px 30px;
    color: #FFFFFF;
    margin-bottom: 24px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: var(--shadow-sm);
}
.enquiry-info-title {
    font-family: var(--font-heading);
    font-size: 1.45rem;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 10px;
}
.enquiry-info-text {
    font-family: var(--font-body);
    color: rgba(255, 255, 255, 0.72);
    font-size: 0.88rem;
    line-height: 1.7;
    margin-bottom: 24px;
}
.enquiry-benefit {
    display: flex;
    gap: 14px;
    margin-bottom: 16px;
    align-items: flex-start;
}
.enquiry-benefit-icon {
    width: 34px;
    height: 34px;
    border-radius: var(--radius-sm);
    background: rgba(141, 198, 63, 0.2);
    border: 1px solid rgba(141, 198, 63, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brand-green);
    flex-shrink: 0;
    margin-top: 2px;
}
.enquiry-benefit-text {
    font-family: var(--font-body);
    font-size: 0.86rem;
    color: rgba(255, 255, 255, 0.82);
    line-height: 1.5;
}

.enquiry-form-card {
    background: #FFFFFF;
    border-radius: var(--radius-xl);
    padding: 44px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border);
}
.form-section-title {
    font-family: var(--font-heading);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--brand-green);
    border-bottom: 2px solid var(--border);
    padding-bottom: 8px;
    margin: 32px 0 20px;
}
.form-section-title:first-child { margin-top: 0; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

@media (max-width: 768px) {
    .enquiry-wrapper { grid-template-columns: 1fr; gap: 36px; padding: 45px 0; }
    .enquiry-sidebar { position: static; }
    .form-row { grid-template-columns: 1fr; }
    .enquiry-form-card { padding: 28px 20px; }
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
                <span>Enquiry Form</span>
            </nav>
            <h1>Request a Custom Quote</h1>
            <p>Tell us about your project and we will get back to you with a detailed quotation within 24 hours.</p>
        </div>
    </div>
</section>

<div class="container">
    <div class="enquiry-wrapper">
        <!-- Sidebar -->
        <div class="enquiry-sidebar" data-aos="fade-right">
            <div class="enquiry-info">
                <h2 class="enquiry-info-title">Why Submit an Enquiry?</h2>
                <p class="enquiry-info-text">Our team reviews every enquiry personally and provides tailored quotations — not generic pricing.</p>

                @php
                $benefits = [
                    ['icon' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>', 'text' => 'Free initial consultation with our design team'],
                    ['icon' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>', 'text' => 'Detailed quotation with no hidden costs'],
                    ['icon' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>', 'text' => 'Response guaranteed within 24 hours'],
                    ['icon' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>', 'text' => '100% custom designs tailored to your brand'],
                    ['icon' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>', 'text' => 'End-to-end service from concept to installation'],
                ];
                @endphp
                @foreach($benefits as $b)
                <div class="enquiry-benefit">
                    <div class="enquiry-benefit-icon">{!! $b['icon'] !!}</div>
                    <div class="enquiry-benefit-text">{{ $b['text'] }}</div>
                </div>
                @endforeach
            </div>

            <!-- Quick Contact Box -->
            <div style="background:var(--bg-alt);border-radius:var(--radius-xl);padding:26px;border:1px solid var(--border)">
                <h4 style="font-family:var(--font-heading);font-size:0.95rem;font-weight:700;color:var(--brand-grey-dark);margin-bottom:14px">Need Immediate Help?</h4>
                @if(!empty($siteSettings['phone1']))
                <a href="tel:{{ str_replace([' ','-'],'', $siteSettings['phone1']) }}" style="display:flex;align-items:center;gap:10px;color:var(--brand-grey-dark);font-weight:600;margin-bottom:12px;font-family:var(--font-heading);font-size:0.9rem">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--brand-green)" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.69 10a19.79 19.79 0 01-3.07-8.67A2 2 0 013.6 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 7.91a16 16 0 006 6l1.27-.85a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 15.92z"/></svg>
                    {{ $siteSettings['phone1'] }}
                </a>
                @endif
                @if(!empty($siteSettings['whatsapp']))
                <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}" target="_blank" style="display:flex;align-items:center;gap:10px;color:#25D366;font-weight:700;font-family:var(--font-heading);font-size:0.9rem">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.555 4.116 1.528 5.85L.057 23.428a.5.5 0 00.515.572l5.736-1.504A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.96 0-3.8-.528-5.383-1.449L4 21l.483-2.497A9.956 9.956 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                    WhatsApp Us
                </a>
                @endif
            </div>
        </div>

        <!-- Enquiry Form -->
        <div data-aos="fade-left">
            <div class="enquiry-form-card">
                <h2 style="font-family:var(--font-heading);font-size:1.85rem;font-weight:700;color:var(--brand-grey-dark);margin-bottom:6px">Enquiry Form</h2>
                <p style="color:var(--text-secondary);margin-bottom:12px;font-size:0.9rem">All fields marked with <span style="color:var(--brand-green);font-weight:bold">*</span> are required.</p>

                @if($errors->any())
                <div class="flash-message flash-error">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Please correct the errors below.
                </div>
                @endif

                <form action="{{ route('enquiry.store') }}" method="POST" enctype="multipart/form-data" id="main-enquiry-form">
                    @csrf
                    <input type="hidden" name="source" value="enquiry">

                    <div class="form-section-title">Personal Information</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="enq_full_name">Full Name <span class="req">*</span></label>
                            <input type="text" id="enq_full_name" name="full_name" class="form-control @error('full_name') error @enderror" value="{{ old('full_name') }}" required placeholder="Your full name">
                            @error('full_name')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="enq_company">Company Name</label>
                            <input type="text" id="enq_company" name="company_name" class="form-control" value="{{ old('company_name') }}" placeholder="Your company / brand">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="enq_mobile">Mobile Number <span class="req">*</span></label>
                            <input type="tel" id="enq_mobile" name="mobile_number" class="form-control @error('mobile_number') error @enderror" value="{{ old('mobile_number') }}" required placeholder="+91 98765 43210">
                            @error('mobile_number')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="enq_email">Email Address</label>
                            <input type="email" id="enq_email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@email.com">
                        </div>
                    </div>

                    <div class="form-section-title">Product Information</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="enq_category">Product Category</label>
                            <select id="enq_category" name="category_id" class="form-control" onchange="loadProducts(this.value)">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ (old('category_id') == $cat->id || (isset($selectedCategory) && $selectedCategory->id == $cat->id)) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="enq_product">Specific Product</label>
                            <select id="enq_product" name="product_id" class="form-control">
                                <option value="">-- Select Product (Optional) --</option>
                                @if(isset($selectedProduct))
                                <option value="{{ $selectedProduct->id }}" selected>{{ $selectedProduct->name }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="enq_product_name">Product / Kiosk Description</label>
                        <input type="text" id="enq_product_name" name="product_name" class="form-control" value="{{ old('product_name') }}" placeholder="e.g., Display Racks, Smart Kiosk, Food Push Cart, etc.">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="enq_quantity">Quantity Required</label>
                            <input type="number" id="enq_quantity" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" placeholder="1">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="enq_budget">Budget Range</label>
                            <select id="enq_budget" name="budget_range" class="form-control">
                                <option value="">-- Select Budget (Optional) --</option>
                                <option value="Below ₹50,000" {{ old('budget_range') == 'Below ₹50,000' ? 'selected' : '' }}>Below ₹50,000</option>
                                <option value="₹50,000 - ₹1,00,000" {{ old('budget_range') == '₹50,000 - ₹1,00,000' ? 'selected' : '' }}>₹50,000 – ₹1,00,000</option>
                                <option value="₹1,00,000 - ₹2,50,000" {{ old('budget_range') == '₹1,00,000 - ₹2,50,000' ? 'selected' : '' }}>₹1,00,000 – ₹2,50,000</option>
                                <option value="₹2,50,000 - ₹5,00,000" {{ old('budget_range') == '₹2,50,000 - ₹5,00,000' ? 'selected' : '' }}>₹2,50,000 – ₹5,00,000</option>
                                <option value="Above ₹5,00,000" {{ old('budget_range') == 'Above ₹5,00,000' ? 'selected' : '' }}>Above ₹5,00,000</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-section-title">Additional Details</div>
                    <div class="form-group">
                        <label class="form-label" for="enq_location">Delivery Location</label>
                        <input type="text" id="enq_location" name="location" class="form-control" value="{{ old('location') }}" placeholder="City, State">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="enq_message">Project Description / Message</label>
                        <textarea id="enq_message" name="message" class="form-control" rows="5" placeholder="Tell us more about your project requirements, specific features, dimensions, branding needs, etc.">{{ old('message') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="enq_attachment">Attach Reference (Optional)</label>
                        <input type="file" id="enq_attachment" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        <div style="font-size:0.78rem;color:var(--text-muted);margin-top:4px">Accepted: PDF, Images, Word documents. Max 5MB.</div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center" id="enquiry-submit-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Submit Enquiry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function loadProducts(categoryId) {
    const productSelect = document.getElementById('enq_product');
    productSelect.innerHTML = '<option value="">Loading...</option>';

    if (!categoryId) {
        productSelect.innerHTML = '<option value="">-- Select Product (Optional) --</option>';
        return;
    }

    fetch(`{{ route('api.products') }}?category_id=${categoryId}`)
        .then(r => r.json())
        .then(products => {
            let html = '<option value="">-- Select Product (Optional) --</option>';
            products.forEach(p => {
                html += `<option value="${p.id}">${p.name}</option>`;
            });
            productSelect.innerHTML = html;
        })
        .catch(() => {
            productSelect.innerHTML = '<option value="">-- Select Product (Optional) --</option>';
        });
}

const catSelect = document.getElementById('enq_category');
if (catSelect && catSelect.value) loadProducts(catSelect.value);
</script>
@endsection
