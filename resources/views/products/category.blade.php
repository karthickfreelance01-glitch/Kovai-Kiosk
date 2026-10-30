@extends('layouts.app')
@section('title', $category->meta_title ?? $category->name . ' | Kovai Kiosk')
@section('meta_description', $category->meta_description ?? $category->description)

@section('content')
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="breadcrumb-sep">›</span>
                <a href="{{ route('products.index') }}">Products</a>
                <span class="breadcrumb-sep">›</span>
                <span>{{ $category->name }}</span>
            </nav>
            <h1>{{ $category->name }}</h1>
            @if($category->description)<p>{{ $category->description }}</p>@endif
        </div>
    </div>
</section>

<section style="padding:80px 0;background:var(--white)">
    <div class="container">
        <!-- Category tabs -->
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:48px" data-aos="fade-up">
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm">All Categories</a>
            @foreach($allCategories as $cat)
            <a href="{{ route('products.category', $cat->slug) }}" class="btn btn-sm {{ $cat->id == $category->id ? 'btn-primary' : 'btn-outline' }}">{{ $cat->name }}</a>
            @endforeach
        </div>

        @if($products->count() > 0)
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:28px">
            @foreach($products as $product)
            <div class="product-card" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                <div class="product-card-image">
                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" loading="lazy">
                    <div class="product-card-actions">
                        <a href="{{ route('products.show', [$category->slug, $product->slug]) }}" class="btn btn-primary btn-sm">View Details</a>
                        <a href="{{ route('enquiry.create', ['product_id' => $product->id]) }}" class="btn btn-sm" style="background:rgba(255,255,255,0.9);color:var(--gold);font-family:'Outfit',sans-serif;font-weight:600;border-radius:50px;padding:10px;flex:1;text-align:center">Enquire</a>
                    </div>
                </div>
                <div class="product-card-body">
                    <div class="product-card-cat">{{ $category->name }}</div>
                    <h2 class="product-card-title" style="font-size:1.1rem">{{ $product->name }}</h2>
                    <p class="product-card-desc">{{ $product->short_description }}</p>
                    @if($product->specifications->count() > 0)
                    <div style="display:flex;flex-wrap:wrap;gap:6px;margin-top:12px">
                        @foreach($product->specifications->take(3) as $spec)
                        <span style="background:var(--ivory-dark);padding:3px 10px;border-radius:20px;font-size:0.72rem;font-family:'Outfit',sans-serif;font-weight:600;color:var(--text-secondary)">{{ $spec->spec_key }}: {{ $spec->spec_value }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:48px">{{ $products->links() }}</div>
        @else
        <div style="text-align:center;padding:80px 0">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="var(--border)" stroke-width="1.5" style="margin:0 auto 20px"><rect x="3" y="3" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
            <h3 style="color:var(--text-muted);margin-bottom:8px">No products in this category yet</h3>
            <p style="color:var(--text-muted);margin-bottom:24px">Check back soon or enquire about custom orders.</p>
            <a href="{{ route('enquiry.create', ['category_id' => $category->id]) }}" class="btn btn-primary">Enquire About This Category</a>
        </div>
        @endif
    </div>
</section>
@endsection
