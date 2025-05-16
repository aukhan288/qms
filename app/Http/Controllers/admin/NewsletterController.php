<?php

namespace App\Http\Controllers\Admin;

use App\Models\Newsletter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsletterController extends Controller
{
    public function index() {
        
        return view('admin.newsletters');

    }

  public function newslettersList(Request $request)
{
    $query = Newsletter::query();

    // Search
    if ($request->has('search') && !empty($request->search['value'])) {
        $search = $request->search['value'];
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('type', 'like', "%{$search}%");
        });
    }

    // Pagination & Sorting
    $total = $query->count();
    $start = $request->start ?? 0;
    $length = $request->length ?? 10;
    $orderColumnIndex = $request->order[0]['column'] ?? 0;
    $orderDirection = $request->order[0]['dir'] ?? 'asc';

    // Define column map
    $columns = ['id', 'name', 'type', 'file_path', 'is_active', 'created_at'];
    $orderByColumn = $columns[$orderColumnIndex] ?? 'id';

    $newsletters = $query
        ->orderBy($orderByColumn, $orderDirection)
        ->skip($start)
        ->take($length)
        ->get();

    return response()->json([
        'draw' => intval($request->draw),
        'recordsTotal' => $total,
        'recordsFiltered' => $total,
        'data' => $newsletters,
    ]);
}

   public function create(Request $request)
{
    // Validate request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:quarterly,half_yearly,yearly',
        'file' => 'required|file|mimes:pdf|max:10240', // max 10MB
    ]);

    try {
        // Store the file
        $path = $request->file('file')->store('newsletters', 'public');

        // Save the newsletter
        Newsletter::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'file_path' => $path,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Newsletter created successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to create newsletter: ' . $e->getMessage());
    }
}
}
