<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSliderController extends Controller
{
    /**
     * Predefined product categories for slider selection.
     */
    protected array $categories = [
        'Smart Kiosk',
        'Push Cart',
        'EV Vehicles',
    ];

    /**
     * Display a listing of hero sliders.
     */
    public function index()
    {
        $sliders = HeroSlider::orderBy('display_order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(15);

        return view('admin.hero-sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new hero slider.
     */
    public function create()
    {
        $categories = $this->categories;
        return view('admin.hero-sliders.create', compact('categories'));
    }

    /**
     * Store a newly created hero slider in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'subtitle'      => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:2000',
            'category'      => 'nullable|string|max:100',
            'button_text'   => 'nullable|string|max:100',
            'button_url'    => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable|boolean',
            'image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'image.max'   => 'The slider image may not be greater than 5 MB.',
            'image.mimes' => 'The slider image must be a file of type: JPG, JPEG, PNG, or WebP.',
        ]);

        $data = $request->except(['image', '_token']);
        $data['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;
        $data['display_order'] = (int) $request->input('display_order', 0);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hero-sliders', 'public');
        }

        HeroSlider::create($data);

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Hero slide created successfully!');
    }

    /**
     * Show the form for editing the specified hero slider.
     */
    public function edit(HeroSlider $hero_slider)
    {
        $categories = $this->categories;
        $slider = $hero_slider;
        return view('admin.hero-sliders.edit', compact('slider', 'categories'));
    }

    /**
     * Update the specified hero slider in storage.
     */
    public function update(Request $request, HeroSlider $hero_slider)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'subtitle'      => 'nullable|string|max:255',
            'description'   => 'nullable|string|max:2000',
            'category'      => 'nullable|string|max:100',
            'button_text'   => 'nullable|string|max:100',
            'button_url'    => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable|boolean',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'image.max'   => 'The slider image may not be greater than 5 MB.',
            'image.mimes' => 'The slider image must be a file of type: JPG, JPEG, PNG, or WebP.',
        ]);

        $data = $request->except(['image', '_token', '_method']);
        $data['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : false;
        $data['display_order'] = (int) $request->input('display_order', 0);

        if ($request->hasFile('image')) {
            $oldImage = $hero_slider->image;
            // Upload and store the new image first
            $newPath = $request->file('image')->store('hero-sliders', 'public');
            $data['image'] = $newPath;

            // Update database record
            $hero_slider->update($data);

            // Safe removal: delete old image only after successful upload and save
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                if (str_starts_with($oldImage, 'hero-sliders/')) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        } else {
            $hero_slider->update($data);
        }

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Hero slide updated successfully!');
    }

    /**
     * Remove the specified hero slider from storage.
     */
    public function destroy(HeroSlider $hero_slider)
    {
        $image = $hero_slider->image;

        $hero_slider->delete();

        // Remove associated uploaded image if stored in hero-sliders
        if ($image && Storage::disk('public')->exists($image)) {
            if (str_starts_with($image, 'hero-sliders/')) {
                Storage::disk('public')->delete($image);
            }
        }

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Hero slide deleted successfully!');
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus(HeroSlider $hero_slider)
    {
        $hero_slider->update([
            'is_active' => !$hero_slider->is_active,
        ]);

        $status = $hero_slider->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Slide #{$hero_slider->id} has been {$status} successfully!");
    }
}
