<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SummaryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SummaryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = SummaryCategory::withCount('summaries')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.summary-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colors = ['blue', 'green', 'orange', 'purple', 'red', 'indigo', 'cyan', 'yellow', 'emerald', 'pink'];
        return view('admin.summary-categories.create', compact('colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:summary_categories,slug',
            'description' => 'nullable|string|max:1000',
            'description_ar' => 'nullable|string|max:1000',
            'color' => 'required|string|in:blue,green,orange,purple,red,indigo,cyan,yellow,emerald,pink',
            'icon' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (SummaryCategory::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Set default sort order
        if (empty($data['sort_order'])) {
            $data['sort_order'] = SummaryCategory::max('sort_order') + 10;
        }

        SummaryCategory::create($data);

        return redirect()->route('admin.summary-categories.index')
            ->with('success', 'Summary category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SummaryCategory $summaryCategory)
    {
        $summaryCategory->load(['summaries' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.summary-categories.show', compact('summaryCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SummaryCategory $summaryCategory)
    {
        $colors = ['blue', 'green', 'orange', 'purple', 'red', 'indigo', 'cyan', 'yellow', 'emerald', 'pink'];
        return view('admin.summary-categories.edit', compact('summaryCategory', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SummaryCategory $summaryCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('summary_categories')->ignore($summaryCategory->id)],
            'description' => 'nullable|string|max:1000',
            'description_ar' => 'nullable|string|max:1000',
            'color' => 'required|string|in:blue,green,orange,purple,red,indigo,cyan,yellow,emerald,pink',
            'icon' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Ensure slug is unique (excluding current category)
        $originalSlug = $data['slug'];
        $counter = 1;
        while (SummaryCategory::where('slug', $data['slug'])->where('id', '!=', $summaryCategory->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $summaryCategory->update($data);

        return redirect()->route('admin.summary-categories.index')
            ->with('success', 'Summary category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SummaryCategory $summaryCategory)
    {
        // Check if category has summaries
        if ($summaryCategory->summaries()->count() > 0) {
            return redirect()->route('admin.summary-categories.index')
                ->with('error', 'Cannot delete category that has summaries. Please reassign or delete the summaries first.');
        }

        $summaryCategory->delete();

        return redirect()->route('admin.summary-categories.index')
            ->with('success', 'Summary category deleted successfully!');
    }

    /**
     * Toggle the active status of a category.
     */
    public function toggleStatus(SummaryCategory $summaryCategory)
    {
        $summaryCategory->update([
            'is_active' => !$summaryCategory->is_active
        ]);

        $status = $summaryCategory->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Summary category {$status} successfully!");
    }
}
