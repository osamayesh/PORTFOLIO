<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\CodeSnippet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::with('category');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
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

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        // Sort by
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $articles = $query->paginate(10)->withQueryString();
        
        // Get hierarchical categories for filter
        $categories = Category::with(['parent', 'children'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Get hierarchical categories for dropdown
        $categories = Category::with(['parent', 'children'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        
        // Handle snippet count and preserve form data when adding snippets
        $snippetCount = $request->get('snippets', 1);
        $formData = $request->except(['_token', 'snippets']);
        
        // Pass the snippet count and form data to the view
        return view('admin.articles.create', compact('categories', 'snippetCount', 'formData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string',
            'read_time' => 'nullable|integer|min:1',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            
            // Code snippets validation
            'code_snippets' => 'nullable|array',
            'code_snippets.*.title_en' => 'nullable|string|max:255',
            'code_snippets.*.title_ar' => 'nullable|string|max:255',
            'code_snippets.*.language' => 'nullable|string|max:50',
            'code_snippets.*.code' => 'nullable|string',
            'code_snippets.*.description_en' => 'nullable|string',
            'code_snippets.*.description_ar' => 'nullable|string',
            'code_snippets.*.order' => 'nullable|integer|min:0',
            'code_snippets.*.filename' => 'nullable|string|max:255',
            'code_snippets.*.show_line_numbers' => 'nullable|boolean',
            'code_snippets.*.content_after' => 'nullable|string',
            'code_snippets.*.content_after_en' => 'nullable|string',
            'code_snippets.*.content_after_ar' => 'nullable|string',
            
            // Comparison tables validation
            'comparison_tables' => 'nullable|array',
            'comparison_tables.*.title_en' => 'nullable|string|max:255',
            'comparison_tables.*.title_ar' => 'nullable|string|max:255',
            'comparison_tables.*.description_en' => 'nullable|string',
            'comparison_tables.*.description_ar' => 'nullable|string',
            'comparison_tables.*.table_data_en' => 'nullable|string',
            'comparison_tables.*.table_data_ar' => 'nullable|string',
            'comparison_tables.*.order' => 'nullable|integer|min:0',
            'comparison_tables.*.show_header' => 'nullable|boolean',
            'comparison_tables.*.show_borders' => 'nullable|boolean',
            'comparison_tables.*.striped_rows' => 'nullable|boolean',
            'comparison_tables.*.table_style' => 'nullable|string|in:default,compact,modern',
        ]);

        // Handle checkbox - if not present, it means unchecked (false)
        $validatedData['is_published'] = $request->has('is_published') && $request->is_published == '1';

        // Generate slug from English title
        $validatedData['slug'] = Str::slug($validatedData['title_en']);
        
        // Ensure slug is unique
        $originalSlug = $validatedData['slug'];
        $counter = 1;
        while (Article::where('slug', $validatedData['slug'])->exists()) {
            $validatedData['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Set legacy title and description for backward compatibility
        $validatedData['title'] = $validatedData['title_en'];
        $validatedData['description'] = $validatedData['description_en'];
        $validatedData['content'] = $validatedData['content_en'];

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug($validatedData['title_en']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/articles', $filename);
            $validatedData['featured_image'] = $filename;
        }

        // Process tags
        if ($validatedData['tags']) {
            $validatedData['tags'] = array_map('trim', explode(',', $validatedData['tags']));
        }

        // Handle published_at based on publication status
        if ($validatedData['is_published']) {
            // If publishing and no date provided, use current time
            if (!$validatedData['published_at']) {
                $validatedData['published_at'] = now();
            }
        } else {
            // If unpublishing, set published_at to null
            $validatedData['published_at'] = null;
        }

        // Use database transaction for safety
        DB::transaction(function () use ($validatedData, $request) {
            // Create the article
            $article = Article::create($validatedData);

            // Create code snippets if provided
            if ($request->has('code_snippets')) {
                foreach ($request->code_snippets as $snippetData) {
                    // Only create snippets that have actual code
                    if (!empty($snippetData['code'])) {
                        $snippetData['article_id'] = $article->id;
                        $snippetData['show_line_numbers'] = isset($snippetData['show_line_numbers']) && $snippetData['show_line_numbers'] === '1';
                        \App\Models\CodeSnippet::create($snippetData);
                    }
                }
            }

            // Create comparison tables if provided
            if ($request->has('comparison_tables')) {
                foreach ($request->comparison_tables as $tableData) {
                    // Only create tables that have actual data
                    if (!empty($tableData['table_data_en']) || !empty($tableData['table_data_ar'])) {
                        $tableData['article_id'] = $article->id;
                        $tableData['show_header'] = isset($tableData['show_header']) && $tableData['show_header'] === '1';
                        $tableData['show_borders'] = isset($tableData['show_borders']) && $tableData['show_borders'] === '1';
                        $tableData['striped_rows'] = isset($tableData['striped_rows']) && $tableData['striped_rows'] === '1';
                        
                        // Parse JSON table data
                        if (!empty($tableData['table_data_en'])) {
                            $tableData['table_data_en'] = json_decode($tableData['table_data_en'], true);
                        }
                        if (!empty($tableData['table_data_ar'])) {
                            $tableData['table_data_ar'] = json_decode($tableData['table_data_ar'], true);
                        }
                        
                        \App\Models\ComparisonTable::create($tableData);
                    }
                }
            }
        });

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        // Get hierarchical categories for dropdown
        $categories = Category::with(['parent', 'children'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
        
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        try {
            $validatedData = $request->validate([
                'title_en' => 'required|string|max:255',
                'title_ar' => 'required|string|max:255',
                'description_en' => 'required|string',
                'description_ar' => 'required|string',
                'content_en' => 'required|string',
                'content_ar' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'tags' => 'nullable|string',
                'read_time' => 'nullable|integer|min:1',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_published' => 'nullable|boolean',
                'published_at' => 'nullable|date',
                
                // Code snippets validation
                'code_snippets' => 'nullable|array',
                'code_snippets.*.id' => 'nullable|integer|exists:code_snippets,id',
                'code_snippets.*.title_en' => 'nullable|string|max:255',
                'code_snippets.*.title_ar' => 'nullable|string|max:255',
                'code_snippets.*.language' => 'nullable|string|max:50',
                'code_snippets.*.code' => 'nullable|string',
                'code_snippets.*.description_en' => 'nullable|string',
                'code_snippets.*.description_ar' => 'nullable|string',
                'code_snippets.*.order' => 'nullable|integer|min:0',
                'code_snippets.*.filename' => 'nullable|string|max:255',
                'code_snippets.*.show_line_numbers' => 'nullable|boolean',
                'code_snippets.*.content_after' => 'nullable|string',
                'code_snippets.*.content_after_en' => 'nullable|string',
                'code_snippets.*.content_after_ar' => 'nullable|string',
                
                // Comparison tables validation
                'comparison_tables' => 'nullable|array',
                'comparison_tables.*.title_en' => 'nullable|string|max:255',
                'comparison_tables.*.title_ar' => 'nullable|string|max:255',
                'comparison_tables.*.description_en' => 'nullable|string',
                'comparison_tables.*.description_ar' => 'nullable|string',
                'comparison_tables.*.table_data_en' => 'nullable|string',
                'comparison_tables.*.table_data_ar' => 'nullable|string',
                'comparison_tables.*.order' => 'nullable|integer|min:0',
                'comparison_tables.*.show_header' => 'nullable|boolean',
                'comparison_tables.*.show_borders' => 'nullable|boolean',
                'comparison_tables.*.striped_rows' => 'nullable|boolean',
                'comparison_tables.*.table_style' => 'nullable|string|in:default,compact,modern',
            ]);

            // Verify the article still exists before updating
            if (!$article->exists) {
                return redirect()->route('admin.articles.index')
                    ->with('error', 'Article not found or has been deleted.');
            }

            // Verify the category exists and is active
            $category = Category::where('id', $validatedData['category_id'])
                              ->where('is_active', true)
                              ->first();
            
            if (!$category) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Selected category is not available.');
            }

            // Handle checkbox - if not present, it means unchecked (false)
            $validatedData['is_published'] = $request->has('is_published') && $request->is_published == '1';

            // Update slug if English title changed
            if ($validatedData['title_en'] !== $article->title_en) {
                $newSlug = Str::slug($validatedData['title_en']);
                $originalSlug = $newSlug;
                $counter = 1;
                while (Article::where('slug', $newSlug)->where('id', '!=', $article->id)->exists()) {
                    $newSlug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $validatedData['slug'] = $newSlug;
            }

            // Set legacy fields for backward compatibility
            $validatedData['title'] = $validatedData['title_en'];
            $validatedData['description'] = $validatedData['description_en'];
            $validatedData['content'] = $validatedData['content_en'];

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                // Store old image path for rollback if needed
                $oldImage = $article->featured_image;

                $image = $request->file('featured_image');
                $filename = time() . '_' . Str::slug($validatedData['title_en']) . '.' . $image->getClientOriginalExtension();
                
                // Upload new image first
                $image->storeAs('public/articles', $filename);
                $validatedData['featured_image'] = $filename;
                
                // Only delete old image after successful upload
                if ($oldImage) {
                    Storage::delete('public/articles/' . $oldImage);
                }
            }

            // Process tags
            if ($validatedData['tags']) {
                $validatedData['tags'] = array_map('trim', explode(',', $validatedData['tags']));
            } else {
                $validatedData['tags'] = null;
            }

            // Handle published_at based on publication status
            if ($validatedData['is_published']) {
                // If publishing and no date provided, use current time
                if (!$validatedData['published_at']) {
                    $validatedData['published_at'] = now();
                }
            } else {
                // If unpublishing, set published_at to null
                $validatedData['published_at'] = null;
            }

            // Use database transaction for safety
            DB::transaction(function () use ($article, $validatedData, $request) {
                $article->update($validatedData);

                // Handle code snippets
                if ($request->has('code_snippets') && is_array($request->code_snippets)) {
                    // Get current snippet IDs
                    $existingSnippetIds = $article->codeSnippets->pluck('id')->toArray();
                    $submittedSnippetIds = [];

                    foreach ($request->code_snippets as $snippetData) {
                        if (!empty($snippetData['code'])) {
                            $snippetData['show_line_numbers'] = isset($snippetData['show_line_numbers']) ? true : false;
                            
                            if (isset($snippetData['id']) && !empty($snippetData['id'])) {
                                // Update existing snippet
                                $snippet = CodeSnippet::find($snippetData['id']);
                                if ($snippet && $snippet->article_id == $article->id) {
                                    $snippet->update($snippetData);
                                    $submittedSnippetIds[] = $snippet->id;
                                }
                            } else {
                                // Create new snippet
                                $snippetData['article_id'] = $article->id;
                                $snippet = CodeSnippet::create($snippetData);
                                $submittedSnippetIds[] = $snippet->id;
                            }
                        }
                    }

                    // Delete snippets that were removed
                    $snippetsToDelete = array_diff($existingSnippetIds, $submittedSnippetIds);
                    if (!empty($snippetsToDelete)) {
                        CodeSnippet::whereIn('id', $snippetsToDelete)->delete();
                    }
                } else {
                    // If no snippets submitted, delete all existing snippets
                    $article->codeSnippets()->delete();
                }

                // Handle comparison tables
                if ($request->has('comparison_tables') && is_array($request->comparison_tables)) {
                    // Get current table IDs
                    $existingTableIds = $article->comparisonTables->pluck('id')->toArray();
                    $submittedTableIds = [];

                    foreach ($request->comparison_tables as $tableData) {
                        if (!empty($tableData['table_data_en']) || !empty($tableData['table_data_ar'])) {
                            $tableData['show_header'] = isset($tableData['show_header']) && $tableData['show_header'] === '1';
                            $tableData['show_borders'] = isset($tableData['show_borders']) && $tableData['show_borders'] === '1';
                            $tableData['striped_rows'] = isset($tableData['striped_rows']) && $tableData['striped_rows'] === '1';
                            
                            if (isset($tableData['id']) && !empty($tableData['id'])) {
                                // Update existing table
                                $table = \App\Models\ComparisonTable::find($tableData['id']);
                                if ($table && $table->article_id == $article->id) {
                                    $table->update($tableData);
                                    $submittedTableIds[] = $table->id;
                                }
                            } else {
                                // Create new table
                                $tableData['article_id'] = $article->id;
                                $table = \App\Models\ComparisonTable::create($tableData);
                                $submittedTableIds[] = $table->id;
                            }
                        }
                    }

                    // Delete tables that were removed
                    $tablesToDelete = array_diff($existingTableIds, $submittedTableIds);
                    if (!empty($tablesToDelete)) {
                        \App\Models\ComparisonTable::whereIn('id', $tablesToDelete)->delete();
                    }
                } else {
                    // If no tables submitted, delete all existing tables
                    $article->comparisonTables()->delete();
                }
            });

            return redirect()->route('admin.articles.index')
                ->with('success', 'Article updated successfully!');
                
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Article update failed: ' . $e->getMessage(), [
                'article_id' => $article->id,
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update article. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Delete featured image
        if ($article->featured_image) {
            Storage::delete('public/articles/' . $article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article deleted successfully!');
    }

    /**
     * Toggle article publication status
     */
    public function toggleStatus(Article $article)
    {
        $newStatus = !$article->is_published;
        
        $article->update([
            'is_published' => $newStatus,
            'published_at' => $newStatus ? now() : null
        ]);

        return response()->json([
            'success' => true,
            'status' => $article->is_published
        ]);
    }
}
