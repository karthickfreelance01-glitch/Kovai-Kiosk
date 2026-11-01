<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutShowcaseProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class AboutShowcaseController extends Controller
{
    /**
     * Display a listing of the products in the About Pathy showcase.
     */
    public function index()
    {
        $showcaseItems = AboutShowcaseProduct::with(['product.category', 'product.images'])
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(15);

        // Products that are not yet added to the showcase
        $existingProductIds = AboutShowcaseProduct::pluck('product_id')->toArray();
        $availableProducts = Product::with(['category', 'images'])
            ->where('is_active', true)
            ->whereNotIn('id', $existingProductIds)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.about-showcase.index', compact('showcaseItems', 'availableProducts'));
    }

    /**
     * Add an existing product to the About Pathy showcase.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id'    => 'required|exists:products,id|unique:about_showcase_products,product_id',
            'display_order' => 'nullable|integer|min:0',
            'custom_badge'  => 'nullable|string|max:100',
            'is_active'     => 'nullable|boolean',
        ], [
            'product_id.unique' => 'This product is already included in the About Pathy showcase.',
        ]);

        $maxOrder = AboutShowcaseProduct::max('display_order') ?? 0;

        AboutShowcaseProduct::create([
            'product_id'    => $request->product_id,
            'display_order' => $request->filled('display_order') ? (int) $request->display_order : ($maxOrder + 1),
            'custom_badge'  => $request->custom_badge,
            'is_active'     => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        return redirect()->route('admin.about-showcase.index')
            ->with('success', 'Product added to About Pathy 3D showcase successfully!');
    }

    /**
     * Update showcase product order, custom badge, or active state.
     */
    public function update(Request $request, AboutShowcaseProduct $aboutShowcase)
    {
        $request->validate([
            'display_order' => 'nullable|integer|min:0',
            'custom_badge'  => 'nullable|string|max:100',
            'is_active'     => 'nullable|boolean',
        ]);

        $aboutShowcase->update([
            'display_order' => (int) $request->input('display_order', 0),
            'custom_badge'  => $request->custom_badge,
            'is_active'     => $request->has('is_active') ? $request->boolean('is_active') : false,
        ]);

        return redirect()->route('admin.about-showcase.index')
            ->with('success', 'Showcase item updated successfully!');
    }

    /**
     * Remove a product from the showcase (does not delete the product itself).
     */
    public function destroy(AboutShowcaseProduct $aboutShowcase)
    {
        $aboutShowcase->delete();

        return redirect()->route('admin.about-showcase.index')
            ->with('success', 'Product removed from About Pathy showcase.');
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus(AboutShowcaseProduct $aboutShowcase)
    {
        $aboutShowcase->update([
            'is_active' => !$aboutShowcase->is_active,
        ]);

        $status = $aboutShowcase->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Showcase item #{$aboutShowcase->id} {$status} successfully!");
    }
}

