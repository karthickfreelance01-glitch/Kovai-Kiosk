<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->orderBy('sort_order')->paginate(20);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function bulkCreate()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get(['id', 'name', 'category_id']);
        return view('admin.products.bulk-upload', compact('categories', 'products'));
    }

    public function bulkUploadItem(Request $request)
    {
        $request->validate([
            'image'         => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:8192',
            'category_id'   => 'required|exists:categories,id',
            'mode'          => 'required|in:individual_products,single_gallery',
            'product_id'    => 'nullable|required_if:mode,single_gallery|exists:products,id',
            'base_name'     => 'nullable|string|max:255',
            'naming_mode'   => 'nullable|in:base_name,filename',
            'description'   => 'nullable|string',
            'is_active'     => 'nullable|boolean',
        ]);

        $file = $request->file('image');
        $path = $file->store('products', 'public');

        if ($request->mode === 'single_gallery') {
            $product = Product::findOrFail($request->product_id);
            $hasPrimary = !empty($product->primary_image) || $product->images()->where('is_primary', true)->exists();
            $maxOrder = $product->images()->max('sort_order') ?? -1;

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => !$hasPrimary,
                'sort_order' => $maxOrder + 1,
            ]);

            if (!$hasPrimary) {
                $product->update(['primary_image' => $path]);
            }

            return response()->json([
                'success'      => true,
                'mode'         => 'single_gallery',
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'image_url'    => asset('storage/' . $path),
            ]);
        }

        // Mode: individual_products (1 product created per uploaded image)
        $category = Category::findOrFail($request->category_id);

        if ($request->naming_mode === 'filename') {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $productName = ucwords(str_replace(['-', '_', '.'], ' ', $originalName));
            if (empty(trim($productName))) {
                $productName = $request->filled('base_name') ? $request->base_name : $category->name;
            }
        } else {
            $productName = $request->filled('base_name') ? $request->base_name : $category->name;
        }

        $slug = Product::generateUniqueSlug($productName);
        $maxOrder = Product::where('category_id', $category->id)->max('sort_order') ?? 0;

        $product = Product::create([
            'category_id'       => $category->id,
            'name'              => $productName,
            'slug'              => $slug,
            'primary_image'     => $path,
            'short_description' => $request->description,
            'description'       => $request->description,
            'is_active'         => $request->boolean('is_active', true),
            'sort_order'        => $maxOrder + 1,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $path,
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        return response()->json([
            'success'      => true,
            'mode'         => 'individual_products',
            'product_id'   => $product->id,
            'product_name' => $product->name,
            'slug'         => $product->slug,
            'image_url'    => asset('storage/' . $path),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'category_id'           => 'required|exists:categories,id',
            'short_description'     => 'nullable|string|max:500',
            'description'           => 'nullable|string',
            'images.*'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'spec_keys.*'           => 'nullable|string|max:255',
            'spec_values.*'         => 'nullable|string|max:255',
            'meta_title'            => 'nullable|string|max:255',
            'meta_description'      => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $data = $request->except(['images', 'spec_keys', 'spec_values', '_token']);
            $data['slug'] = Product::generateUniqueSlug($request->name);
            $data['features'] = $request->features ? json_decode($request->features, true) : null;

            $product = Product::create($data);

            // Handle multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    $isPrimary = ($index === 0);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $isPrimary,
                        'sort_order' => $index,
                    ]);
                    if ($isPrimary) {
                        $product->update(['primary_image' => $path]);
                    }
                }
            }

            // Handle specifications
            if ($request->has('spec_keys')) {
                foreach ($request->spec_keys as $i => $key) {
                    if ($key && isset($request->spec_values[$i])) {
                        ProductSpecification::create([
                            'product_id' => $product->id,
                            'spec_key'   => $key,
                            'spec_value' => $request->spec_values[$i],
                            'sort_order' => $i,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $product->load(['images', 'specifications']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $product) {
            $data = $request->except(['images', 'spec_keys', 'spec_values', '_token', '_method']);

            $product->update($data);

            // Add new images
            if ($request->hasFile('images')) {
                $maxOrder = $product->images()->max('sort_order') ?? -1;
                $hasPrimary = $product->images()->where('is_primary', true)->exists() || !empty($product->primary_image);
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    $isPrimary = (!$hasPrimary && $index === 0);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $isPrimary,
                        'sort_order' => $maxOrder + $index + 1,
                    ]);
                    if ($isPrimary) {
                        $product->update(['primary_image' => $path]);
                        $hasPrimary = true;
                    }
                }
            }

            // Update specifications
            $product->specifications()->delete();
            if ($request->has('spec_keys')) {
                foreach ($request->spec_keys as $i => $key) {
                    if ($key && isset($request->spec_values[$i])) {
                        ProductSpecification::create([
                            'product_id' => $product->id,
                            'spec_key'   => $key,
                            'spec_value' => $request->spec_values[$i],
                            'sort_order' => $i,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        if ($product->primary_image) {
            Storage::disk('public')->delete($product->primary_image);
        }
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);

        $wasPrimary = $image->is_primary;
        $productId  = $image->product_id;
        $image->delete();

        // If deleted primary, set new primary
        if ($wasPrimary) {
            $newPrimary = ProductImage::where('product_id', $productId)->first();
            if ($newPrimary) {
                $newPrimary->update(['is_primary' => true]);
                Product::where('id', $productId)->update(['primary_image' => $newPrimary->image_path]);
            }
        }

        return back()->with('success', 'Image deleted.');
    }

    public function setPrimaryImage(ProductImage $image)
    {
        ProductImage::where('product_id', $image->product_id)->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);
        Product::where('id', $image->product_id)->update(['primary_image' => $image->image_path]);

        return back()->with('success', 'Primary image updated.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Product status updated.');
    }
}
