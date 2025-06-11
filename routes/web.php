<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SummaryController as AdminSummaryController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\SummaryCategoryController as AdminSummaryCategoryController;

Route::get('/', function () {
    return view('welcome');
});

// Test route for Tailwind CSS
Route::get('/test', function () {
    return view('test');
});

// Articles routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index')->middleware('throttle:60,1');
Route::get('/articles/category/{slug}', [ArticleController::class, 'byCategory'])->name('articles.category')->middleware('throttle:60,1');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show')->middleware('throttle:30,1');

// Also add route for the other pages we've set up in the navigation
Route::get('/about', function () {
    return view('About');
});

Route::get('/education', function () {
    return view('Education');
});

Route::get('/services', function () {
    return view('Services');
});

Route::get('/projects', function () {
    return view('Project');
});

// Summary routes
Route::get('/summaries', [SummaryController::class, 'index'])->name('summaries.index')->middleware('throttle:60,1');
Route::get('/summaries/books', [SummaryController::class, 'index'])->defaults('category', 'books')->middleware('throttle:60,1');
Route::get('/summaries/courses', [SummaryController::class, 'index'])->defaults('category', 'courses')->middleware('throttle:60,1');
Route::get('/summaries/documentation', [SummaryController::class, 'index'])->defaults('category', 'documentation')->middleware('throttle:60,1');
Route::get('/summaries/research', [SummaryController::class, 'index'])->defaults('category', 'research')->middleware('throttle:60,1');

// Summary API routes
Route::get('/api/summaries/{id}', [SummaryController::class, 'show'])->name('summaries.show')->middleware('throttle:30,1');
Route::get('/summaries/{id}/view', [SummaryController::class, 'view'])->name('summaries.view')->middleware('throttle:10,1');
Route::get('/summaries/{id}/download', [SummaryController::class, 'download'])->name('summaries.download')->middleware('throttle:5,1');
Route::get('/pdfs/{filename}', [SummaryController::class, 'servePdf'])->name('pdfs.serve')->middleware('throttle:10,1');

Route::get('/contact', function () {
    return view('contact');
});

// Language Switcher Route
Route::get('/language/{locale}', [\App\Http\Controllers\LanguageController::class, 'switchLang'])->name('language.switch');

// Global login route redirect
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Admin Authentication Routes (Custom)
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes (not authenticated)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
        Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [AdminAuthController::class, 'register'])->name('register.post');
    });
    
    // Authenticated routes
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Category routes
        Route::resource('categories', AdminCategoryController::class);
        Route::post('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        
        // Summary Categories Routes
        Route::resource('summary-categories', AdminSummaryCategoryController::class);
        Route::post('summary-categories/{summaryCategory}/toggle-status', [AdminSummaryCategoryController::class, 'toggleStatus'])
            ->name('summary-categories.toggle-status');
        
        // Summary routes with file upload protection
        Route::resource('summaries', AdminSummaryController::class)->middleware('secure.upload');
        Route::post('summaries/{summary}/toggle-status', [AdminSummaryController::class, 'toggleStatus'])->name('summaries.toggle-status');
        
        // Article routes with file upload protection
        Route::resource('articles', AdminArticleController::class)->middleware('secure.upload');
        Route::post('articles/{article}/toggle-status', [AdminArticleController::class, 'toggleStatus'])->name('articles.toggle-status');
    });
});

// Test route for category functionality
Route::get('/test-categories', function () {
    $categories = \App\Models\Category::with(['parent', 'children'])->get();
    
    echo "<h1>Category Test</h1>";
    echo "<h2>Total Categories: " . $categories->count() . "</h2>";
    
    echo "<h3>Main Categories (no parent):</h3>";
    $mainCategories = $categories->whereNull('parent_id');
    foreach ($mainCategories as $category) {
        echo "<div style='margin: 10px; padding: 10px; border: 1px solid #ccc;'>";
        echo "<strong>ID: {$category->id}</strong> - {$category->name} ({$category->name_ar})<br>";
        echo "Children: " . $category->children->count() . "<br>";
        
        if ($category->children->count() > 0) {
            echo "<div style='margin-left: 20px;'>";
            foreach ($category->children as $child) {
                echo "└── <strong>ID: {$child->id}</strong> - {$child->name} ({$child->name_ar})<br>";
            }
            echo "</div>";
        }
        echo "</div>";
    }
    
    echo "<h3>All Categories with Parent Info:</h3>";
    foreach ($categories as $category) {
        $parentInfo = $category->parent ? "Parent: {$category->parent->name}" : "Main Category";
        echo "<div>ID: {$category->id} - {$category->name} - {$parentInfo}</div>";
    }
    
    return "";
});
