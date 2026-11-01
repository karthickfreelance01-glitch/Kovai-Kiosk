<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\Project;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@kovaikiok.com'],
            [
                'name'              => 'Admin',
                'email'             => 'admin@kovaikiok.com',
                'password'          => Hash::make('Admin@123'),
                'is_admin'          => true,
                'email_verified_at' => now(),
            ]
        );

        // Website Settings
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'Kovai Kiosk', 'group' => 'general', 'type' => 'text', 'label' => 'Site Name'],
            ['key' => 'tagline', 'value' => 'Engineering Your Vision', 'group' => 'general', 'type' => 'text', 'label' => 'Tagline'],
            ['key' => 'logo', 'value' => null, 'group' => 'general', 'type' => 'image', 'label' => 'Logo'],
            ['key' => 'footer_logo', 'value' => null, 'group' => 'general', 'type' => 'image', 'label' => 'Footer Logo'],
            ['key' => 'favicon', 'value' => null, 'group' => 'general', 'type' => 'image', 'label' => 'Favicon'],
            ['key' => 'announcement_bar', 'value' => '🏭 Custom Kiosk Manufacturing | Premium Quality | Free Consultation Available', 'group' => 'general', 'type' => 'text', 'label' => 'Announcement Bar'],
            ['key' => 'announcement_bar_enabled', 'value' => '1', 'group' => 'general', 'type' => 'boolean', 'label' => 'Show Announcement Bar'],
            // Contact
            ['key' => 'phone1', 'value' => '+91 98765 43210', 'group' => 'contact', 'type' => 'text', 'label' => 'Phone 1'],
            ['key' => 'phone2', 'value' => '+91 98765 43211', 'group' => 'contact', 'type' => 'text', 'label' => 'Phone 2'],
            ['key' => 'email', 'value' => 'info@kovaikiok.com', 'group' => 'contact', 'type' => 'text', 'label' => 'Email'],
            ['key' => 'whatsapp', 'value' => '919876543210', 'group' => 'contact', 'type' => 'text', 'label' => 'WhatsApp Number'],
            ['key' => 'address', 'value' => '123, Industrial Area, Coimbatore, Tamil Nadu - 641001', 'group' => 'contact', 'type' => 'textarea', 'label' => 'Address'],
            ['key' => 'business_hours', 'value' => 'Mon - Sat: 9:00 AM – 6:00 PM', 'group' => 'contact', 'type' => 'text', 'label' => 'Business Hours'],
            ['key' => 'google_maps_url', 'value' => 'https://maps.google.com', 'group' => 'contact', 'type' => 'text', 'label' => 'Google Maps URL'],
            // Social
            ['key' => 'facebook', 'value' => 'https://facebook.com', 'group' => 'social', 'type' => 'text', 'label' => 'Facebook URL'],
            ['key' => 'instagram', 'value' => 'https://instagram.com', 'group' => 'social', 'type' => 'text', 'label' => 'Instagram URL'],
            ['key' => 'youtube', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'YouTube URL'],
            ['key' => 'linkedin', 'value' => '', 'group' => 'social', 'type' => 'text', 'label' => 'LinkedIn URL'],
            // SEO
            ['key' => 'meta_title', 'value' => 'Kovai Kiosk | Premium Kiosk & Mobile Cart Manufacturers', 'group' => 'seo', 'type' => 'text', 'label' => 'Meta Title'],
            ['key' => 'meta_description', 'value' => 'Leading manufacturer of smart kiosks, push carts and EV vehicles in Coimbatore. Custom designs, premium quality, professional installation.', 'group' => 'seo', 'type' => 'textarea', 'label' => 'Meta Description'],
            ['key' => 'google_analytics', 'value' => '', 'group' => 'seo', 'type' => 'text', 'label' => 'Google Analytics ID'],
            // Footer
            ['key' => 'footer_description', 'value' => 'Leading manufacturer of premium smart kiosks, mobile carts and EV vehicles. We transform your business vision into extraordinary real-world experiences.', 'group' => 'footer', 'type' => 'textarea', 'label' => 'Footer Description'],
            ['key' => 'copyright_text', 'value' => '© 2024 Kovai Kiosk. All Rights Reserved.', 'group' => 'footer', 'type' => 'text', 'label' => 'Copyright Text'],
        ];

        foreach ($settings as $setting) {
            WebsiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // Categories
        $categories = [
            ['name' => 'Smart Kiosk', 'slug' => 'smart-kiosk', 'description' => 'Modern, tech-enabled smart kiosk solutions for retail, food service, and information displays.', 'sort_order' => 1, 'is_featured' => true, 'icon' => 'monitor'],
            ['name' => 'Push Cart', 'slug' => 'push-cart', 'description' => 'Elegant mobile push carts perfect for street food, retail, and events.', 'sort_order' => 2, 'is_featured' => true, 'icon' => 'shopping-cart'],
            ['name' => 'EV Vehicles', 'slug' => 'ev-vehicles', 'description' => 'Electric vehicle kiosks and mobile units for sustainable business solutions.', 'sort_order' => 3, 'is_featured' => true, 'icon' => 'zap'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], array_merge($cat, ['is_active' => true]));
        }

        // Sample Products
        $smartKiosk = Category::where('slug', 'smart-kiosk')->first();
        $pushCart    = Category::where('slug', 'push-cart')->first();
        $evVehicles  = Category::where('slug', 'ev-vehicles')->first();

        $products = [
            [
                'category_id'       => $smartKiosk->id,
                'name'              => 'Premium Retail Kiosk',
                'slug'              => 'premium-retail-kiosk',
                'short_description' => 'Elegant retail kiosk with integrated digital display, lockable storage, and premium branding surfaces.',
                'description'       => 'Our Premium Retail Kiosk combines luxury aesthetics with functional design. Built with powder-coated steel frame, tempered glass display counters, and LED accent lighting. Perfect for malls, airports, and premium retail environments.',
                'is_featured'       => true,
                'is_active'         => true,
                'sort_order'        => 1,
                'features'          => ['LED Lighting System', 'Lockable Storage', 'Digital Display Ready', 'Custom Branding', 'Power Outlets Included'],
            ],
            [
                'category_id'       => $smartKiosk->id,
                'name'              => 'Food & Beverage Kiosk',
                'slug'              => 'food-beverage-kiosk',
                'short_description' => 'Hygienic, commercial-grade food kiosk with stainless steel worktops and equipment mounting.',
                'description'       => 'Designed for food and beverage businesses. Features stainless steel food-safe surfaces, integrated sink options, power provisions for commercial equipment, and attractive branding panels.',
                'is_featured'       => true,
                'is_active'         => true,
                'sort_order'        => 2,
                'features'          => ['Stainless Steel Surfaces', 'Equipment Mounting', 'Hygienic Design', 'Water Connection Ready', 'Ventilation System'],
            ],
            [
                'category_id'       => $pushCart->id,
                'name'              => 'Luxury Mobile Push Cart',
                'slug'              => 'luxury-mobile-push-cart',
                'short_description' => 'Premium mobile push cart with elegant wooden finish, custom branding and smooth-rolling wheels.',
                'description'       => 'A premium mobile push cart with hardwood-look finish, stainless steel accessories, and ergonomic design. Perfect for coffee, juice, and artisan retail. Easy to maneuver with heavy-duty wheels and braking system.',
                'is_featured'       => true,
                'is_active'         => true,
                'sort_order'        => 1,
                'features'          => ['Premium Wood Finish', 'Heavy-duty Wheels with Brakes', 'Weatherproof Canopy', 'Storage Drawers', 'Custom Branding'],
            ],
            [
                'category_id'       => $evVehicles->id,
                'name'              => 'Electric Food Truck',
                'slug'              => 'electric-food-truck',
                'short_description' => 'Zero-emission electric food truck with full kitchen setup and premium exterior branding.',
                'description'       => 'Our Electric Food Truck offers a sustainable solution for mobile food businesses. Features zero-emission drive system, fully equipped kitchen interior, commercial refrigeration, and eye-catching custom branding.',
                'is_featured'       => true,
                'is_active'         => true,
                'sort_order'        => 1,
                'features'          => ['Zero Emissions', 'Full Kitchen Setup', 'Solar Panel Ready', 'Commercial Refrigeration', 'GPS Tracking'],
            ],
        ];

        foreach ($products as $prod) {
            $features = $prod['features'];
            unset($prod['features']);
            $prod['features'] = json_encode($features);

            $product = Product::updateOrCreate(['slug' => $prod['slug']], $prod);

            // Add sample specs
            $specsMap = [
                'premium-retail-kiosk' => [['Width', '1200mm'], ['Height', '1050mm'], ['Depth', '600mm'], ['Material', 'Powder Coated Steel'], ['Weight', '85 kg']],
                'food-beverage-kiosk'  => [['Width', '1500mm'], ['Height', '1100mm'], ['Depth', '700mm'], ['Material', 'SS304 Stainless Steel'], ['Capacity', '2-3 Staff']],
                'luxury-mobile-push-cart' => [['Width', '900mm'], ['Height', '1200mm'], ['Depth', '500mm'], ['Material', 'Hardwood & Steel'], ['Wheel Size', '8 inch']],
                'electric-food-truck'  => [['Length', '4.5m'], ['Width', '1.8m'], ['Battery', '60kWh'], ['Range', '200km'], ['Kitchen Area', '8 sq.m']],
            ];

            $product->specifications()->delete();
            foreach (($specsMap[$prod['slug']] ?? []) as $i => [$key, $value]) {
                ProductSpecification::create(['product_id' => $product->id, 'spec_key' => $key, 'spec_value' => $value, 'sort_order' => $i]);
            }
        }

        // Sample Projects
        $projectsData = [
            ['title' => 'CCD Coffee Kiosk – Phoenix Mall', 'category_id' => $smartKiosk->id, 'location' => 'Chennai', 'is_featured' => true],
            ['title' => 'Juice Cart – Marina Beach', 'category_id' => $pushCart->id, 'location' => 'Chennai', 'is_featured' => true],
            ['title' => 'Ice Cream Kiosk – Brookefields Mall', 'category_id' => $smartKiosk->id, 'location' => 'Coimbatore', 'is_featured' => true],
            ['title' => 'EV Food Van – Bengaluru Market', 'category_id' => $evVehicles->id, 'location' => 'Bengaluru', 'is_featured' => true],
        ];

        foreach ($projectsData as $proj) {
            Project::updateOrCreate(['slug' => Str::slug($proj['title'])], array_merge($proj, ['slug' => Str::slug($proj['title']), 'is_active' => true]));
        }

        // Hero Sliders
        $this->call(HeroSliderSeeder::class);
    }
}
