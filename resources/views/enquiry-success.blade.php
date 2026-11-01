@extends('layouts.app')
@section('title', 'Enquiry Submitted | Pathy Display Racks & Kovai Kiosk')

@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:60px 20px;background:var(--bg)">
    <div style="max-width:540px;width:100%;text-align:center" data-aos="zoom-in">
        <!-- Success Icon -->
        <div style="width:90px;height:90px;margin:0 auto 28px;background:var(--brand-green);border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 14px 36px rgba(141,198,63,0.35)">
            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
        </div>

        <div style="font-family:var(--font-heading);font-size:0.75rem;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--brand-green);margin-bottom:12px">Enquiry Received</div>
        <h1 style="font-family:var(--font-heading);font-size:2.2rem;font-weight:700;color:var(--brand-grey-dark);margin-bottom:14px">Thank You, {{ $enquiry->full_name }}!</h1>
        <p style="color:var(--text-secondary);font-size:1rem;line-height:1.75;margin-bottom:32px">
            Your enquiry has been submitted successfully. Our team will review your requirements and get back to you within <strong>24 hours</strong>.
        </p>

        <!-- Reference Card -->
        <div style="background:var(--bg-alt);border:1px solid var(--border);border-radius:var(--radius-xl);padding:26px;margin-bottom:32px">
            <div style="font-family:var(--font-heading);font-size:0.72rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--text-muted);margin-bottom:6px">Your Enquiry Reference Number</div>
            <div style="font-family:var(--font-heading);font-size:2rem;font-weight:800;color:var(--brand-green);letter-spacing:2px">{{ $enquiry->reference_number }}</div>
            <div style="font-size:0.82rem;color:var(--text-muted);margin-top:6px">Please save this reference number for follow-ups.</div>
        </div>

        <!-- Enquiry Details -->
        <div style="background:#FFFFFF;border:1px solid var(--border);border-radius:var(--radius-xl);padding:28px;text-align:left;margin-bottom:32px;box-shadow:var(--shadow-sm)">
            <h4 style="font-family:var(--font-heading);font-size:0.82rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--brand-grey-dark);margin-bottom:16px">Enquiry Summary</h4>
            <div style="display:flex;flex-direction:column;gap:12px">
                <div style="display:flex;gap:16px">
                    <span style="font-family:var(--font-heading);font-size:0.84rem;font-weight:600;color:var(--text-muted);min-width:120px">Name</span>
                    <span style="font-size:0.9rem;font-weight:600;color:var(--brand-grey-dark)">{{ $enquiry->full_name }}</span>
                </div>
                @if($enquiry->company_name)
                <div style="display:flex;gap:16px">
                    <span style="font-family:var(--font-heading);font-size:0.84rem;font-weight:600;color:var(--text-muted);min-width:120px">Company</span>
                    <span style="font-size:0.9rem;color:var(--brand-grey-dark)">{{ $enquiry->company_name }}</span>
                </div>
                @endif
                <div style="display:flex;gap:16px">
                    <span style="font-family:var(--font-heading);font-size:0.84rem;font-weight:600;color:var(--text-muted);min-width:120px">Mobile</span>
                    <span style="font-size:0.9rem;color:var(--brand-grey-dark)">{{ $enquiry->mobile_number }}</span>
                </div>
                @if($enquiry->category)
                <div style="display:flex;gap:16px">
                    <span style="font-family:var(--font-heading);font-size:0.84rem;font-weight:600;color:var(--text-muted);min-width:120px">Category</span>
                    <span style="font-size:0.9rem;color:var(--brand-grey-dark)">{{ $enquiry->category->name }}</span>
                </div>
                @endif
                <div style="display:flex;gap:16px">
                    <span style="font-family:var(--font-heading);font-size:0.84rem;font-weight:600;color:var(--text-muted);min-width:120px">Submitted</span>
                    <span style="font-size:0.9rem;color:var(--brand-grey-dark)">{{ $enquiry->created_at->format('d M Y, h:i A') }}</span>
                </div>
            </div>
        </div>

        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
            <a href="{{ route('home') }}" class="btn btn-primary" id="success-home-btn">Back to Home</a>
            <a href="{{ route('products.index') }}" class="btn btn-outline" id="success-products-btn">Browse Products</a>
        </div>
    </div>
</div>
@endsection
