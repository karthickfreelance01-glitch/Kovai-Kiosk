<?php

namespace Database\Seeders;

use App\Models\AboutShowcaseProduct;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AboutShowcaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Populate missing public/images assets with real product & kiosk images
        $publicImagesDir = public_path('images');
        if (!File::isDirectory($publicImagesDir)) {
            File::makeDirectory($publicImagesDir, 0755, true);
        }

        $sourceProductsDir = storage_path('app/public/products');
        $availableImages = File::exists($sourceProductsDir) ? File::files($sourceProductsDir) : [];

        if (count($availableImages) > 0) {
            $img0 = $availableImages[0]->getPathname();
            $img1 = $availableImages[min(1, count($availableImages) - 1)]->getPathname();
            $img2 = $availableImages[min(2, count($availableImages) - 1)]->getPathname();
            $img3 = $availableImages[min(3, count($availableImages) - 1)]->getPathname();

            File::copy($img0, $publicImagesDir . '/about-factory.jpg');
            File::copy($img1, $publicImagesDir . '/manufacturing2.jpg');
            File::copy($img2, $publicImagesDir . '/manufacturing.jpg');
            File::copy($img3, $publicImagesDir . '/product2.jpg');
            File::copy($img0, $publicImagesDir . '/placeholder-product.jpg');
            File::copy($img1, $publicImagesDir . '/placeholder-category.jpg');
            File::copy($img2, $publicImagesDir . '/placeholder-project.jpg');
        }

        // 2. Populate showcase with the real active catalogue products in order
        $products = Product::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        $customBadges = [
            1 => 'Interactive Tech',
            2 => 'Gourmet Mobility',
            3 => 'Aesthetic Retail',
            4 => 'Zero Emission EV',
            5 => 'Airport Self-Service',
        ];

        foreach ($products as $index => $product) {
            AboutShowcaseProduct::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'display_order' => $index + 1,
                    'is_active'     => true,
                    'custom_badge'  => $customBadges[$product->id] ?? 'Signature Model',
                ]
            );
        }
    }
}

