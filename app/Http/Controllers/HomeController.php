<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HeroSlider;
use App\Models\Product;
use App\Models\Project;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCategories = Category::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        if ($featuredCategories->isEmpty()) {
            $featuredCategories = Category::where('is_active', true)
                ->orderBy('sort_order')
                ->take(6)
                ->get();
        }

        $featuredProducts = Product::with(['category', 'images'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $projects = Project::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $allCategories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $heroSliders = HeroSlider::active()->get();

        return view('home', compact(
            'heroSliders',
            'featuredCategories',
            'featuredProducts',
            'projects',
            'allCategories'
        ));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
