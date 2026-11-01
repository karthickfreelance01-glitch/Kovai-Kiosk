@extends('layouts.app')
@section('title', $product->meta_title ?? $product->name . ' | Pathy Display Racks & Kovai Kiosk')
@section('meta_description', $product->meta_description ?? $product->short_description)

@section('styles')
<style>
.product-detail-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 60px; padding: 70px 0; }
.gallery-main { aspect-ratio: 4/3; border-radius: var(--radius-xl); overflow: hidden; background: var(--bg-alt); margin-bottom: 14px; border: 1px solid var(--border); }
.gallery-main img { width: 100%; height: 100%; object-fit: cover; }
.gallery-thumbs { display: flex; gap: 10px; }
.gallery-thumb { width: 72px; height: 72px; border-radius: var(--radius); overflow: hidden; cursor: pointer; border: 2.5px solid transparent; transition: border-color 0.2s; flex-shrink: 0; background: var(--bg-alt); }
.gallery-thumb.active { border-color: var(--brand-green); }
.gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }
.product-cat-label { font-family: var(--font-heading); font-size: 0.75rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--brand-green); margin-bottom: 10px; }
.product-title { font-family: var(--font-heading); font-size: clamp(1.6rem, 3vw, 2.3rem); font-weight: 700; color: var(--brand-grey-dark); margin-bottom: 14px; line-height: 1.25; }
.product-short-desc { font-family: var(--font-body); color: var(--text-secondary); line-height: 1.75; margin-bottom: 24px; font-size: 0.95rem; }
.specs-table { width: 100%; border-collapse: collapse; margin: 18px 0; }
.specs-table td { padding: 11px 16px; border-bottom: 1px solid var(--border); font-size: 0.88rem; }
.specs-table td:first-child { font-weight: 600; color: var(--brand-grey-dark); width: 40%; }
.features-list { list-style: none; margin: 18px 0; display: flex; flex-direction: column; gap: 10px; }
.features-list li { display: flex; gap: 10px; align-items: flex-start; font-size: 0.9rem; color: var(--text-primary); }
.features-list li::before { content: '✓'; color: var(--brand-green); font-weight: 800; font-size: 0.9rem; flex-shrink: 0; margin-top: 1px; }
.enquiry-box { background: var(--bg-alt); border-radius: var(--radius-lg); padding: 26px; border: 1px solid var(--border); margin-top: 32px; }
.section-toggle { font-family: var(--font-heading); font-size: 0.82rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--brand-grey-dark); border-bottom: 2px solid var(--border); padding-bottom: 10px; margin: 28px 0 16px; }
.related-section { padding: 65px 0; background: var(--bg-alt); border-top: 1px solid var(--border); }
@media (max-width: 768px) {
    .product-detail-grid { grid-template-columns: 1fr; gap: 36px; padding: 40px 0; }
}
</style>
@endsection

@section('content')
<!-- Page Hero -->
<section class="page-hero" style="padding:45px 0">
    <div class="container">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-sep">›</span>
            <a href="{{ route('products.index') }}">Products</a>
            <span class="breadcrumb-sep">›</span>
            <a href="{{ route('products.category', $category->slug) }}">{{ $category->name }}</a>
            <span class="breadcrumb-sep">›</span>
            <span>{{ $product->name }}</span>
        </nav>
    </div>
</section>

<div class="container">
    <div class="product-detail-grid">
        <!-- Gallery -->
        <div data-aos="fade-right">
            <div class="gallery-main" id="gallery-main">
                @php
                    $mainImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                @endphp
                @if($mainImage)
                    <img src="{{ $mainImage->url }}" alt="{{ $product->name }}" id="gallery-main-img" loading="eager">
                @elseif($product->primary_image)
                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" id="gallery-main-img" loading="eager">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg-alt)">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="var(--border)" stroke-width="1.5"><rect x="3" y="3" width="18" height="13" rx="2"/></svg>
                    </div>
                @endif
            </div>
            @if($product->images->count() > 1)
            <div class="gallery-thumbs">
                @foreach($product->images as $img)
                <div class="gallery-thumb {{ ($mainImage && $img->id === $mainImage->id) ? 'active' : '' }}" onclick="changeImage('{{ $img->url }}', this)">
                    <img src="{{ $img->url }}" alt="{{ $product->name }}" loading="lazy">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div data-aos="fade-left">
            <div class="product-cat-label">{{ $category->name }}</div>
            <h1 class="product-title">{{ $product->name }}</h1>
            <p class="product-short-desc">{{ $product->short_description }}</p>

            <!-- CTA Buttons -->
            <div style="display:flex;gap:14px;flex-wrap:wrap">
                <a href="{{ route('enquiry.create', ['product_id' => $product->id]) }}" class="btn btn-primary" id="product-enquire-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    Enquire Now
                </a>
                @if(!empty($siteSettings['whatsapp']))
                <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}?text=Hi%2C%20I%20am%20interested%20in%20{{ urlencode($product->name) }}." target="_blank" class="btn btn-outline" style="border-color:#25D366;color:#25D366" id="product-whatsapp-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#25D366"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/></svg>
                    WhatsApp
                </a>
                @endif
            </div>

            <!-- Specifications -->
            @if($product->specifications->count() > 0)
            <div class="section-toggle">Specifications</div>
            <table class="specs-table">
                @foreach($product->specifications as $spec)
                <tr>
                    <td>{{ $spec->spec_key }}</td>
                    <td>{{ $spec->spec_value }}</td>
                </tr>
                @endforeach
            </table>
            @endif

            <!-- Features -->
            @php $feats = is_array($product->features) ? $product->features : json_decode($product->features ?? '[]', true); @endphp
            @if(!empty($feats) && count($feats) > 0)
            <div class="section-toggle">Key Features</div>
            <ul class="features-list">
                @foreach($feats as $feature)
                <li>{{ $feature }}</li>
                @endforeach
            </ul>
            @endif

            <!-- Customization Options -->
            @php $customOpts = is_array($product->customization_options) ? $product->customization_options : json_decode($product->customization_options ?? '[]', true); @endphp
            @if(!empty($customOpts) && count($customOpts) > 0)
            <div class="section-toggle">Customization Options</div>
            <ul class="features-list">
                @foreach($customOpts as $opt)
                <li>{{ $opt }}</li>
                @endforeach
            </ul>
            @endif

            <!-- Enquiry Box -->
            <div class="enquiry-box">
                <h4 style="font-family:var(--font-heading);font-size:0.95rem;font-weight:700;color:var(--brand-grey-dark);margin-bottom:8px">Looking for Custom Options?</h4>
                <p style="font-size:0.86rem;color:var(--text-secondary);margin-bottom:16px;line-height:1.6">We can customize this product to fit your exact requirements — dimensions, materials, branding and more.</p>
                <a href="{{ route('enquiry.create', ['product_id' => $product->id]) }}" class="btn btn-primary btn-sm" id="product-custom-enquiry-btn">Request Custom Quote</a>
            </div>
        </div>
    </div>

    <!-- Full Description -->
    @if($product->description)
    <div style="padding:0 0 60px" data-aos="fade-up">
        <div class="section-toggle">Product Description</div>
        <div style="line-height:1.8;color:var(--text-secondary);font-size:0.95rem">{!! nl2br(e($product->description)) !!}</div>
    </div>
    @endif
</div>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="related-section">
    <div class="container">
        <h2 style="font-size:1.8rem;margin-bottom:32px;font-family:var(--font-heading);font-weight:700;color:var(--brand-grey-dark)" data-aos="fade-up">Related Products</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:24px">
            @foreach($relatedProducts as $related)
            <a href="{{ route('products.show', [$category->slug, $related->slug]) }}" class="product-card" style="display:block" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="product-card-image">
                    <img src="{{ $related->primary_image_url }}" alt="{{ $related->name }}" loading="lazy" onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
                </div>
                <div class="product-card-body">
                    <h3 class="product-card-title" style="font-size:1.05rem">{{ $related->name }}</h3>
                    <p class="product-card-desc" style="-webkit-line-clamp:2">{{ $related->short_description }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@section('scripts')
<script>
function changeImage(src, thumb) {
    document.getElementById('gallery-main-img').src = src;
    document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}
</script>
@endsection
