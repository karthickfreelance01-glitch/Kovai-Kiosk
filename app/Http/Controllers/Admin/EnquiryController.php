<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\EnquiryNote;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Enquiry::with(['category', 'product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                  ->orWhere('mobile_number', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('reference_number', 'like', "%$search%")
                  ->orWhere('company_name', 'like', "%$search%");
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $enquiries = $query->latest()->paginate(20);
        $categories = Category::where('is_active', true)->get();
        $statusOptions = Enquiry::STATUS_LABELS;

        return view('admin.enquiries.index', compact('enquiries', 'categories', 'statusOptions'));
    }

    public function show(Enquiry $enquiry)
    {
        $enquiry->load(['category', 'product', 'notes.user']);
        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function updateStatus(Request $request, Enquiry $enquiry)
    {
        $request->validate([
            'status' => 'required|in:new,contacted,follow_up,quotation_sent,converted,closed',
        ]);

        $enquiry->update(['status' => $request->status]);

        if ($request->status === 'contacted' && !$enquiry->contacted_at) {
            $enquiry->update(['contacted_at' => now()]);
        }

        return back()->with('success', 'Status updated successfully.');
    }

    public function addNote(Request $request, Enquiry $enquiry)
    {
        $request->validate(['note' => 'required|string|max:1000']);

        EnquiryNote::create([
            'enquiry_id' => $enquiry->id,
            'user_id'    => auth()->id(),
            'note'       => $request->note,
        ]);

        return back()->with('success', 'Note added.');
    }

    public function destroy(Enquiry $enquiry)
    {
        if ($enquiry->attachment) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($enquiry->attachment);
        }
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')
            ->with('success', 'Enquiry deleted.');
    }

    public function export(Request $request)
    {
        $query = Enquiry::with(['category', 'product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $enquiries = $query->latest()->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="enquiries_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($enquiries) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Ref No', 'Date', 'Full Name', 'Company', 'Mobile', 'Email',
                'Category', 'Product', 'Quantity', 'Budget', 'Location', 'Message', 'Status',
            ]);
            foreach ($enquiries as $e) {
                fputcsv($handle, [
                    $e->reference_number,
                    $e->created_at->format('d/m/Y H:i'),
                    $e->full_name,
                    $e->company_name,
                    $e->mobile_number,
                    $e->email,
                    optional($e->category)->name,
                    $e->product_name ?? optional($e->product)->name,
                    $e->quantity,
                    $e->budget_range,
                    $e->location,
                    $e->message,
                    $e->status_label,
                ]);
            }
            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
