<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    public function create(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $selectedProduct = null;
        $selectedCategory = null;

        if ($request->has('product_id')) {
            $selectedProduct = Product::find($request->product_id);
        }
        if ($request->has('category_id')) {
            $selectedCategory = Category::find($request->category_id);
        }

        return view('enquiry', compact('categories', 'selectedProduct', 'selectedCategory'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name'    => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'category_id'  => 'nullable|exists:categories,id',
            'product_id'   => 'nullable|exists:products,id',
            'product_name' => 'nullable|string|max:255',
            'quantity'     => 'nullable|integer|min:1',
            'budget_range' => 'nullable|string|max:100',
            'location'     => 'nullable|string|max:255',
            'message'      => 'nullable|string|max:2000',
            'attachment'   => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('enquiry-attachments', 'public');
        }

        $data['source'] = $request->input('source', 'website');

        $enquiry = Enquiry::create($data);

        return redirect()->route('enquiry.success', $enquiry->reference_number)
            ->with('success', 'Your enquiry has been submitted successfully!');
    }

    public function success($reference)
    {
        $enquiry = Enquiry::where('reference_number', $reference)->firstOrFail();
        return view('enquiry-success', compact('enquiry'));
    }

    public function getProducts(Request $request)
    {
        $products = Product::where('category_id', $request->category_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($products);
    }
}
