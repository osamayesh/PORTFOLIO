<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['parent', 'children'])
            ->withCount('articles')
            ->mainCategories()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::mainCategories()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
            
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255|unique:categories,name',
            'name_ar' => 'required|string|max:255|unique:categories,name_ar',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Prevent circular reference - subcategories cannot have children
        if ($request->parent_id && $request->parent_id != null) {
            $parentCategory = Category::find($request->parent_id);
            if ($parentCategory && $parentCategory->parent_id) {
                return back()->withErrors(['parent_id' => 'Cannot create subcategory under another subcategory.']);
            }
        }
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Category::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Set default sort order
        if (empty($data['sort_order'])) {
            $data['sort_order'] = Category::max('sort_order') + 10;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function show(Category $category)
    {
        $category->load(['articles' => function ($query) {
            $query->latest()->take(10);
        }, 'parent', 'children']);

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::mainCategories()
            ->where('is_active', true)
            ->where('id', '!=', $category->id) // Exclude self
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
            
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'name_ar' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)],
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        
        // Prevent circular reference and ensure only 2 levels
        if ($request->parent_id && $request->parent_id != null) {
            // Cannot set parent to self
            if ($request->parent_id == $category->id) {
                return back()->withErrors(['parent_id' => 'Category cannot be its own parent.']);
            }
            
            // Cannot set parent to one of its children
            $childrenIds = $category->children->pluck('id')->toArray();
            if (in_array($request->parent_id, $childrenIds)) {
                return back()->withErrors(['parent_id' => 'Cannot set a child category as parent.']);
            }
            
            // Subcategories cannot have children
            $parentCategory = Category::find($request->parent_id);
            if ($parentCategory && $parentCategory->parent_id) {
                return back()->withErrors(['parent_id' => 'Cannot create subcategory under another subcategory.']);
            }
            
            // If this category has children, it cannot become a subcategory
            if ($category->children->count() > 0) {
                return back()->withErrors(['parent_id' => 'Categories with subcategories cannot become subcategories themselves.']);
            }
        }
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Ensure slug is unique (excluding current category)
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Category::where('slug', $data['slug'])->where('id', '!=', $category->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        // Check if category has articles
        if ($category->articles()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category that has articles. Please reassign or delete the articles first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    public function toggleStatus(Category $category)
    {
        $category->update([
            'is_active' => !$category->is_active
        ]);

        $status = $category->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Category {$status} successfully!");
    }
} 