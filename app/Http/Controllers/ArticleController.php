<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        // Get all categories with their published articles count
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($category) {
                $category->article_count = $category->publishedArticles()->count();
                return $category;
            });

        // Handle search
        $searchTerm = $request->get('search');
        $articlesQuery = Article::published();

        if ($searchTerm) {
            $articles = $articlesQuery->search($searchTerm)
                                     ->orderBy('published_at', 'desc')
                                     ->get();
            $selectedCategory = null; // No specific category when searching
        } else {
            // Show all articles by default
            $selectedCategory = null;
            $articles = $articlesQuery
                ->orderBy('published_at', 'desc')
                ->get();
        }

        // Calculate total articles count
        $totalArticles = Article::published()->count();

        return view('articles', compact('categories', 'articles', 'selectedCategory', 'totalArticles', 'searchTerm'));
    }

    public function byCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        
        $articles = Article::published()
            ->where('category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->get();

        // Get all categories for the sidebar
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($cat) {
                $cat->article_count = $cat->publishedArticles()->count();
                return $cat;
            });

        $totalArticles = Article::published()->count();

        return view('articles', compact('categories', 'articles', 'category', 'totalArticles'));
    }

    public function show($slug)
    {
        $article = Article::published()
            ->with('codeSnippets')
            ->where('slug', $slug)
            ->firstOrFail();

        // Record unique view
        $isUniqueView = $article->recordUniqueView();
        
        // You can optionally pass this information to the view
        // to show a message or track analytics
        
        return view('article-detail', compact('article'));
    }
}
