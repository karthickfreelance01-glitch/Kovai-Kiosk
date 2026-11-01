<?php

namespace Database\Seeders;

use App\Models\HeroSlider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HeroSliderSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure storage directory exists
        Storage::disk('public')->makeDirectory('hero-sliders');

        $slides = [
            [
                'title'         => 'Smart Interactive Kiosks',
                'subtitle'      => 'Precision Engineered Self-Service Tech',
                'description'   => 'Commercial touch display kiosks, self-checkout counters, and ticket vending solutions built with industrial durability.',
                'source_image'  => 'products/hUlCzc5JLxJJxAB8GkeUDftJafQRACDPdliVYLOW.jpg',
                'target_image'  => 'hero-sliders/smart-kiosk-hero.jpg',
                'category'      => 'Smart Kiosk',
                'button_text'   => 'Explore Smart Kiosks',
                'button_url'    => '/products/smart-kiosk',
                'display_order' => 1,
                'is_active'     => true,
            ],
            [
                'title'         => 'Luxury Mobile Push Carts',
                'subtitle'      => 'Aesthetic Retail & Gourmet Mobility',
                'description'   => 'Handcrafted premium push carts designed for shopping malls, outdoor markets, festivals, and high-end street food vendors.',
                'source_image'  => 'products/r6K3E7reHnwAQDhWMishFnaG4DgtABS8WpvFawuv.jpg',
                'target_image'  => 'hero-sliders/push-cart-hero.jpg',
                'category'      => 'Push Cart',
                'button_text'   => 'View Push Carts',
                'button_url'    => '/products/push-cart',
                'display_order' => 2,
                'is_active'     => true,
            ],
            [
                'title'         => 'Electric Commercial Vehicles',
                'subtitle'      => 'Eco-Friendly Mobile Vending Units',
                'description'   => 'Customized zero-emission EV food trucks and mobile service vehicles engineered for modern green enterprises.',
                'source_image'  => 'products/UUw3qTHDq1kNZvrXCQh96PICwcq8cKVCWxSHX9B5.jpg',
                'target_image'  => 'hero-sliders/ev-vehicles-hero.jpg',
                'category'      => 'EV Vehicles',
                'button_text'   => 'Discover EV Solutions',
                'button_url'    => '/products/ev-vehicles',
                'display_order' => 3,
                'is_active'     => true,
            ],
        ];

        foreach ($slides as $item) {
            $imagePath = $item['target_image'];

            // Copy file from source to hero-sliders target if available
            $sourceFullPath = storage_path('app/public/' . $item['source_image']);
            $targetFullPath = storage_path('app/public/' . $item['target_image']);

            if (File::exists($sourceFullPath)) {
                File::copy($sourceFullPath, $targetFullPath);
            } elseif (Storage::disk('public')->exists($item['source_image'])) {
                Storage::disk('public')->copy($item['source_image'], $item['target_image']);
            } else {
                // If source not found, keep target_image path
                $imagePath = $item['source_image'];
            }

            HeroSlider::updateOrCreate(
                ['title' => $item['title']],
                [
                    'subtitle'      => $item['subtitle'],
                    'description'   => $item['description'],
                    'image'         => $imagePath,
                    'category'      => $item['category'],
                    'button_text'   => $item['button_text'],
                    'button_url'    => $item['button_url'],
                    'display_order' => $item['display_order'],
                    'is_active'     => $item['is_active'],
                ]
            );
        }
    }
}
