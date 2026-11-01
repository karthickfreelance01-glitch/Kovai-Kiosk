<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BulkImportProducts extends Command
{
    protected $signature = 'products:bulk-import 
                            {category : Category name (e.g. "Smart Kiosk") or Category ID} 
                            {folder : Absolute or relative path to folder containing images}
                            {--name= : Optional base product name (defaults to category name)}
                            {--naming=base_name : "base_name" (e.g. Smart Kiosk, Smart Kiosk 1) or "filename"}';

    protected $description = 'Import 50+ photos from a folder as products in a single command with unique slugs';

    public function handle()
    {
        $categoryInput = $this->argument('category');
        $folderPath = $this->argument('folder');
        $baseName = $this->option('name');
        $naming = $this->option('naming') ?: 'base_name';

        // 1. Resolve Category
        $category = is_numeric($categoryInput)
            ? Category::find($categoryInput)
            : Category::where('name', 'like', $categoryInput)->first();

        if (!$category) {
            $this->error("Category '{$categoryInput}' not found!");
            $available = Category::pluck('name')->implode(', ');
            $this->info("Available categories: {$available}");
            return 1;
        }

        // 2. Validate folder
        if (!File::isDirectory($folderPath)) {
            $this->error("Folder not found: {$folderPath}");
            return 1;
        }

        // 3. Find images
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        $files = collect(File::files($folderPath))
            ->filter(fn($file) => in_array(strtolower($file->getExtension()), $allowedExtensions))
            ->values();

        if ($files->isEmpty()) {
            $this->warn("No supported images (jpg, jpeg, png, webp) found in {$folderPath}");
            return 1;
        }

        $this->info("Found {$files->count()} image(s) to import into Category: [{$category->name}]");
        $baseProductName = $baseName ?: $category->name;

        $bar = $this->output->createProgressBar($files->count());
        $bar->start();

        $imported = [];
        $maxOrder = Product::where('category_id', $category->id)->max('sort_order') ?? 0;

        foreach ($files as $file) {
            $filename = Str::random(40) . '.' . $file->getExtension();
            $storageRelativePath = 'products/' . $filename;

            // Copy file to storage
            Storage::disk('public')->put($storageRelativePath, File::get($file->getRealPath()));

            if ($naming === 'filename') {
                $rawName = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                $prodName = ucwords(str_replace(['-', '_', '.'], ' ', $rawName));
                if (empty(trim($prodName))) {
                    $prodName = $baseProductName;
                }
            } else {
                $prodName = $baseProductName;
            }

            $slug = Product::generateUniqueSlug($prodName);
            $maxOrder++;

            $product = Product::create([
                'category_id'   => $category->id,
                'name'          => $prodName,
                'slug'          => $slug,
                'primary_image' => $storageRelativePath,
                'is_active'     => true,
                'sort_order'    => $maxOrder,
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $storageRelativePath,
                'is_primary' => true,
                'sort_order' => 0,
            ]);

            $imported[] = [
                'id'   => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'file' => $file->getFilename(),
            ];

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✓ Successfully imported {$files->count()} product(s) into [{$category->name}]!");
        $this->table(['ID', 'Product Name', 'Unique Slug', 'Original Image File'], array_slice($imported, 0, 10));

        if (count($imported) > 10) {
            $this->line("... and " . (count($imported) - 10) . " more products.");
        }

        return 0;
    }
}

