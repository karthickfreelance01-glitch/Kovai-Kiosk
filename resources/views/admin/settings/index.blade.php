@extends('layouts.admin')
@section('title', 'Website Settings')
@section('page-title', 'Global Settings & Brand Management')

@section('content')
<div class="page-head">
    <div>
        <h1 class="page-head-title">Website Configuration & Brand Setup</h1>
        <p class="page-head-sub">Manage global contact channels, header announcement bar, logos, social handles, and SEO metadata.</p>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div style="display:flex;flex-direction:column;gap:28px;max-width:950px">

        <!-- 1. General & Branding -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Brand Identity & Header Announcement</h2>
                    <p style="font-size:0.75rem;color:var(--admin-muted)">Company brand identity, logos, and header ticker</p>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-site-name">Website / Company Name</label>
                        <input type="text" id="st-site-name" name="settings[site_name]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('site_name', 'Kovai Kiosk') }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-tagline">Company Tagline</label>
                        <input type="text" id="st-tagline" name="settings[tagline]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('tagline', 'Engineering Your Vision') }}">
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-announce">Top Announcement Bar Text</label>
                        <input type="text" id="st-announce" name="settings[announcement_bar]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('announcement_bar') }}" placeholder="e.g. 🏭 Custom Kiosk Manufacturing | Free Consultation Available">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-announce-toggle">Show Announcement Bar?</label>
                        <select id="st-announce-toggle" name="settings[announcement_bar_enabled]" class="admin-form-control">
                            <option value="1" {{ \App\Models\WebsiteSetting::get('announcement_bar_enabled', '1') == '1' ? 'selected' : '' }}>Enabled (Visible on Website)</option>
                            <option value="0" {{ \App\Models\WebsiteSetting::get('announcement_bar_enabled', '1') == '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                </div>

                <!-- Logos & Favicon Grid -->
                <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:16px;margin-top:10px;padding-top:16px;border-top:1px solid var(--admin-border)">
                    <!-- Main Logo -->
                    <div>
                        <label class="admin-form-label">Primary Header Logo</label>
                        @if(\App\Models\WebsiteSetting::get('logo'))
                            <div style="padding:10px;background:#000;border-radius:6px;margin-bottom:8px;text-align:center">
                                <img src="{{ asset('storage/' . \App\Models\WebsiteSetting::get('logo')) }}" alt="Logo" style="max-height:40px">
                            </div>
                        @endif
                        <input type="file" name="logo" class="admin-form-control" accept="image/*">
                    </div>

                    <!-- Footer Logo -->
                    <div>
                        <label class="admin-form-label">Footer Logo</label>
                        @if(\App\Models\WebsiteSetting::get('footer_logo'))
                            <div style="padding:10px;background:#000;border-radius:6px;margin-bottom:8px;text-align:center">
                                <img src="{{ asset('storage/' . \App\Models\WebsiteSetting::get('footer_logo')) }}" alt="Footer Logo" style="max-height:40px">
                            </div>
                        @endif
                        <input type="file" name="footer_logo" class="admin-form-control" accept="image/*">
                    </div>

                    <!-- Favicon -->
                    <div>
                        <label class="admin-form-label">Favicon (Icon)</label>
                        @if(\App\Models\WebsiteSetting::get('favicon'))
                            <div style="padding:10px;background:#000;border-radius:6px;margin-bottom:8px;text-align:center">
                                <img src="{{ asset('storage/' . \App\Models\WebsiteSetting::get('favicon')) }}" alt="Favicon" style="max-height:32px">
                            </div>
                        @endif
                        <input type="file" name="favicon" class="admin-form-control" accept="image/*,.ico">
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Contact Information -->
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h2 class="admin-card-title">Contact Channels & Plant Location</h2>
                    <p style="font-size:0.75rem;color:var(--admin-muted)">Phone numbers, official email, and WhatsApp connection</p>
                </div>
            </div>
            <div class="admin-card-body">
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-phone1">Primary Phone Number</label>
                        <input type="text" id="st-phone1" name="settings[phone1]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('phone1', '+91 98765 43210') }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-phone2">Secondary Phone / Landline</label>
                        <input type="text" id="st-phone2" name="settings[phone2]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('phone2', '+91 98765 43211') }}">
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-email">Official Enquiry Email</label>
                        <input type="email" id="st-email" name="settings[email]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('email', 'info@kovaikiok.com') }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-whatsapp">WhatsApp Sales Number (with country code, no +)</label>
                        <input type="text" id="st-whatsapp" name="settings[whatsapp]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('whatsapp', '919876543210') }}" placeholder="919876543210">
                        <small style="font-size:0.72rem;color:var(--admin-muted)">Used for instant WhatsApp floating button and lead clicks.</small>
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-hours">Business Working Hours</label>
                        <input type="text" id="st-hours" name="settings[business_hours]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('business_hours', 'Mon - Sat: 9:00 AM – 6:00 PM') }}">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-maps">Google Maps Embed URL</label>
                        <input type="text" id="st-maps" name="settings[google_maps_url]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('google_maps_url', 'https://maps.google.com') }}">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="st-address">Manufacturing Works Address</label>
                    <textarea id="st-address" name="settings[address]" class="admin-form-control" style="min-height:75px">{{ \App\Models\WebsiteSetting::get('address', '123, Industrial Area, Coimbatore, Tamil Nadu - 641001') }}</textarea>
                </div>
            </div>
        </div>

        <!-- 3. Social Media Links -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Social Media Presence</h2>
            </div>
            <div class="admin-card-body">
                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-fb">Facebook URL</label>
                        <input type="url" id="st-fb" name="settings[facebook]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('facebook') }}" placeholder="https://facebook.com/...">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-insta">Instagram URL</label>
                        <input type="url" id="st-insta" name="settings[instagram]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('instagram') }}" placeholder="https://instagram.com/...">
                    </div>
                </div>

                <div class="admin-form-row">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-yt">YouTube Channel URL</label>
                        <input type="url" id="st-yt" name="settings[youtube]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('youtube') }}" placeholder="https://youtube.com/...">
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label" for="st-li">LinkedIn Profile URL</label>
                        <input type="url" id="st-li" name="settings[linkedin]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('linkedin') }}" placeholder="https://linkedin.com/company/...">
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Footer Content -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Footer Description & Copyright</h2>
            </div>
            <div class="admin-card-body">
                <div class="admin-form-group">
                    <label class="admin-form-label" for="st-footer-desc">Footer Company Summary</label>
                    <textarea id="st-footer-desc" name="settings[footer_description]" class="admin-form-control" style="min-height:75px">{{ \App\Models\WebsiteSetting::get('footer_description') }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="st-copy">Copyright Notice Text</label>
                    <input type="text" id="st-copy" name="settings[copyright_text]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('copyright_text', '© 2024 Kovai Kiosk. All Rights Reserved.') }}">
                </div>
            </div>
        </div>

        <!-- 5. Global SEO & Analytics -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Search Engine Optimization & Google Analytics</h2>
            </div>
            <div class="admin-card-body">
                <div class="admin-form-group">
                    <label class="admin-form-label" for="st-meta-title">Global SEO Title</label>
                    <input type="text" id="st-meta-title" name="settings[meta_title]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('meta_title') }}" placeholder="Kovai Kiosk | Premium Kiosk & Mobile Cart Manufacturers">
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="st-meta-desc">Global Meta Description</label>
                    <textarea id="st-meta-desc" name="settings[meta_description]" class="admin-form-control" style="min-height:80px">{{ \App\Models\WebsiteSetting::get('meta_description') }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="st-ga">Google Analytics Measurement ID</label>
                    <input type="text" id="st-ga" name="settings[google_analytics]" class="admin-form-control" value="{{ \App\Models\WebsiteSetting::get('google_analytics') }}" placeholder="G-XXXXXXXXXX">
                </div>
            </div>
        </div>

        <!-- Save Button Bar -->
        <div style="position:sticky;bottom:20px;z-index:20;background:var(--admin-sidebar);border:1px solid var(--admin-border);border-radius:12px;padding:16px 24px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 10px 30px rgba(0,0,0,0.5)">
            <span style="font-size:0.85rem;color:var(--admin-muted)">Changes take effect immediately across all frontend and backend views.</span>
            <button type="submit" class="btn-admin btn-admin-primary" style="padding:10px 28px;font-size:0.95rem">
                Save All Settings
            </button>
        </div>

    </div>
</form>
@endsection
