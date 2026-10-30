<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products'    => Product::count(),
            'total_categories'  => Category::count(),
            'total_enquiries'   => Enquiry::count(),
            'new_enquiries'     => Enquiry::where('status', 'new')->count(),
            'pending_enquiries' => Enquiry::whereIn('status', ['contacted', 'follow_up'])->count(),
            'converted'         => Enquiry::where('status', 'converted')->count(),
            'total_projects'    => Project::count(),
        ];

        $recentEnquiries = Enquiry::with('category')
            ->latest()
            ->take(10)
            ->get();

        $enquiryByStatus = Enquiry::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $monthlyEnquiries = Enquiry::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('admin.dashboard', compact('stats', 'recentEnquiries', 'enquiryByStatus', 'monthlyEnquiries'));
    }
}
