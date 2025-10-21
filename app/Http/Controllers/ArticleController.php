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

    /**
     * Chat with AI about an article
     */
    public function chatWithAI(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'message' => 'required|string|max:1000',
            'article_content' => 'required|string'
        ]);

        $apiKey = env('GEMINI_API_KEY');
        
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'error' => 'API key not configured'
            ], 500);
        }

        try {
            $article = Article::findOrFail($request->article_id);
            $userMessage = $request->message;
            $articleContent = $request->article_content;
            $locale = app()->getLocale();

            // Prepare the prompt
            $systemPrompt = "أنت مساعد ذكي متخصص في شرح وتلخيص المقالات التقنية بطريقة واضحة ومفيدة.";
            
            $fullPrompt = "{$systemPrompt}\n\n";
            $fullPrompt .= "المقال:\n{$articleContent}\n\n";
            $fullPrompt .= "سؤال المستخدم: {$userMessage}\n\n";
            $fullPrompt .= $locale === 'ar' 
                ? "الرجاء الإجابة بالعربية بطريقة واضحة ومفيدة." 
                : "Please answer in English clearly and helpfully.";

            // Call Gemini API
            $response = $this->callGeminiAPI($apiKey, $fullPrompt);

            if ($response['success']) {
                return response()->json([
                    'success' => true,
                    'response' => $response['text']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => $response['error']
                ], 500);
            }

        } catch (\Exception $e) {
            \Log::error('AI Chat Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while processing your request'
            ], 500);
        }
    }

    /**
     * Call Gemini API
     */
    private function callGeminiAPI($apiKey, $prompt)
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 1000,
                'topP' => 0.8,
                'topK' => 10
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        // Fix for SSL certificate issue on Windows
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Log the response for debugging
        \Log::info('Gemini API Response', [
            'http_code' => $httpCode,
            'curl_error' => $curlError,
            'response' => $response
        ]);

        if ($curlError) {
            \Log::error('cURL Error: ' . $curlError);
            return [
                'success' => false,
                'error' => 'Network error: ' . $curlError
            ];
        }

        if ($httpCode === 200) {
            $result = json_decode($response, true);
            
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return [
                    'success' => true,
                    'text' => $result['candidates'][0]['content']['parts'][0]['text']
                ];
            }
            
            // Log if structure is unexpected
            \Log::warning('Unexpected API response structure', ['result' => $result]);
        } else {
            // Log non-200 responses
            \Log::error('Gemini API Error', [
                'http_code' => $httpCode,
                'response' => $response
            ]);
        }

        return [
            'success' => false,
            'error' => 'Failed to get response from AI (HTTP ' . $httpCode . ')'
        ];
    }
}
