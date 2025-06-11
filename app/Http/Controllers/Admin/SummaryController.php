<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Summary;
use App\Http\Requests\StoreSummaryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Summary::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                  ->orWhere('title_ar', 'like', "%{$search}%")
                  ->orWhere('description_en', 'like', "%{$search}%")
                  ->orWhere('description_ar', 'like', "%{$search}%");
            });
        }

        // Sort by
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $summaries = $query->paginate(10)->withQueryString();
        
        $categories = Summary::select('category')->distinct()->pluck('category');

        return view('admin.summaries.index', compact('summaries', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'api', 
            'git', 
            'advanced', 
            'books', 
            'courses', 
            'documentation',
            'frameworks',
            'databases',
            'security',
            'devops'
        ];
        $colorSchemes = ['blue', 'green', 'orange', 'purple'];
        
        return view('admin.summaries.create', compact('categories', 'colorSchemes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSummaryRequest $request)
    {
        $data = $request->validated();

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $filename = time() . '_' . Str::slug($data['title_en']) . '.pdf';
            $file->storeAs('public/pdfs', $filename);
            $data['pdf_file_path'] = $filename;
        }

        Summary::create($data);

        return redirect()->route('admin.summaries.index')
            ->with('success', 'Summary created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Summary $summary)
    {
        return view('admin.summaries.show', compact('summary'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Summary $summary)
    {
        $categories = [
            'api', 
            'git', 
            'advanced', 
            'books', 
            'courses', 
            'documentation',
            'frameworks',
            'databases',
            'security',
            'devops'
        ];
        $colorSchemes = ['blue', 'green', 'orange', 'purple'];
        
        return view('admin.summaries.edit', compact('summary', 'categories', 'colorSchemes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSummaryRequest $request, Summary $summary)
    {
        $data = $request->validated();

        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            // Delete old file
            if ($summary->pdf_file_path) {
                Storage::delete('public/pdfs/' . $summary->pdf_file_path);
            }

            $file = $request->file('pdf_file');
            $filename = time() . '_' . Str::slug($data['title_en']) . '.pdf';
            $file->storeAs('public/pdfs', $filename);
            $data['pdf_file_path'] = $filename;
        }

        $summary->update($data);

        return redirect()->route('admin.summaries.index')
            ->with('success', 'Summary updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Summary $summary)
    {
        // Delete PDF file
        if ($summary->pdf_file_path) {
            Storage::delete('public/pdfs/' . $summary->pdf_file_path);
        }

        $summary->delete();

        return redirect()->route('admin.summaries.index')
            ->with('success', 'Summary deleted successfully!');
    }

    public function toggleStatus(Summary $summary)
    {
        $summary->update(['is_active' => !$summary->is_active]);

        return response()->json([
            'success' => true,
            'status' => $summary->is_active
        ]);
    }
}
