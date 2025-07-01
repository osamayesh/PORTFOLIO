<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Summary;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            // Summary stats
            'total_summaries' => Summary::count(),
            'active_summaries' => Summary::where('is_active', true)->count(),
            'summary_categories' => Summary::select('category')->distinct()->count(),
            'recent_summaries' => Summary::latest()->take(5)->get(),
            'summary_category_counts' => Summary::selectRaw('category, COUNT(*) as count')
                ->groupBy('category')
                ->get()
                ->pluck('count', 'category')
                ->toArray(),
            
            // Article stats
            'total_articles' => Article::count(),
            'published_articles' => Article::where('is_published', true)->count(),
            'draft_articles' => Article::where('is_published', false)->count(),
            'recent_articles' => Article::with('category')->latest()->take(5)->get(),
            'article_categories' => Category::where('is_active', true)->count(),
            'article_category_counts' => Article::join('categories', 'articles.category_id', '=', 'categories.id')
                ->selectRaw('categories.name_ar as category_name, COUNT(*) as count')
                ->groupBy('categories.id', 'categories.name_ar')
                ->get()
                ->pluck('count', 'category_name')
                ->toArray(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
