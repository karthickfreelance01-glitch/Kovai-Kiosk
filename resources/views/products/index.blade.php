@extends('layouts.app')
@section('title', 'Our Products | Kovai Kiosk')

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <nav class="breadcrumb"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>Products</span></nav>
            <h1>Our Product Range</h1>
            <p>Premium kiosks, carts, and EV vehicles — all custom manufactured to your specifications.</p>
        </div>
    </div>
</section>

<section style="padding:80px 0;background:var(--white)">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">Browse Categories</div>
            <h2 class="section-title">What We Manufacture</h2>
        </div>
        <div class="grid-3" style="margin-top:40px">
            @foreach($categories as $cat)
            <a href="{{ route('products.category', $cat->slug) }}" class="card" style="text-decoration:none;display:block" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                @if($cat->image)
                <div style="aspect-ratio:16/9;overflow:hidden;background:var(--ivory-dark)">
                    <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s" loading="lazy">
                </div>
                @else
                <div style="aspect-ratio:16/9;background:linear-gradient(135deg,var(--navy),var(--charcoal));display:flex;align-items:center;justify-content:center">
                    <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="rgba(201,168,76,0.4)" stroke-width="1.5"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </div>
                @endif
                <div style="padding:24px">
                    <div style="font-family:'Outfit',sans-serif;font-size:0.7rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:8px">
                        {{ $cat->activeProducts_count ?? 0 }} Products
                    </div>
                    <h3 style="font-size:1.3rem;margin-bottom:8px">{{ $cat->name }}</h3>
                    <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:16px;line-height:1.6">{{ Str::limit($cat->description, 100) }}</p>
                    <span style="font-family:'Outfit',sans-serif;font-size:0.85rem;font-weight:700;color:var(--gold)">
                        Explore → 
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

@if($featuredProducts->count() > 0)
<section style="padding:80px 0;background:var(--ivory)">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-label">Editor's Pick</div>
            <h2 class="section-title">Featured Products</h2>
        </div>
        <div class="products-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:28px;margin-top:40px">
            @foreach($featuredProducts as $product)
            <div class="product-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                <div class="product-card-image">
                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" loading="lazy">
                    <div class="product-card-badge">Featured</div>
                    <div class="product-card-actions">
                        <a href="{{ route('products.show', [$product->category->slug, $product->slug]) }}" class="btn btn-primary btn-sm">View Details</a>
                        <a href="{{ route('enquiry.create', ['product_id' => $product->id]) }}" class="btn btn-sm" style="background:rgba(255,255,255,0.9);color:var(--gold);font-family:'Outfit',sans-serif;font-weight:600;border-radius:50px;padding:10px;flex:1;display:flex;align-items:center;justify-content:center">Enquire</a>
                    </div>
                </div>
                <div class="product-card-body">
                    <div class="product-card-cat">{{ optional($product->category)->name }}</div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-desc">{{ $product->short_description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
