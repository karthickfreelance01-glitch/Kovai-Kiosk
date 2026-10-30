<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['activeProducts'])
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = Product::with(['category', 'images', 'specifications'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('products.index', compact('categories', 'featuredProducts'));
    }

    public function category(Category $category)
    {
        abort_if(!$category->is_active, 404);

        $products = Product::with(['images', 'specifications'])
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        $allCategories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('products.category', compact('category', 'products', 'allCategories'));
    }

    public function show(Category $category, Product $product)
    {
        abort_if(!$product->is_active, 404);
        $product->load(['category', 'images', 'specifications']);

        $relatedProducts = Product::with(['images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'category', 'relatedProducts'));
    }
}
