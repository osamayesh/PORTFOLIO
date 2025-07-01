<?php

namespace App\Http\Controllers;

use App\Models\Summary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SummaryController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category');
        
        $summariesQuery = Summary::active()->orderBy('sort_order')->orderBy('created_at', 'desc');
        
        if ($category) {
            $summariesQuery->byCategory($category);
        }
        
        $summaries = $summariesQuery->get();
        
        // Group summaries by category for display
        $groupedSummaries = $summaries->groupBy('category');
        
        // Get category counts
        $categoryCounts = [
            'total' => Summary::active()->count(),
            'api' => Summary::active()->byCategory('api')->count(),
            'git' => Summary::active()->byCategory('git')->count(),
            'advanced' => Summary::active()->byCategory('advanced')->count(),
            'books' => Summary::active()->byCategory('books')->count(),
            'courses' => Summary::active()->byCategory('courses')->count(),
            'documentation' => Summary::active()->byCategory('documentation')->count(),
            'frameworks' => Summary::active()->byCategory('frameworks')->count(),
            'databases' => Summary::active()->byCategory('databases')->count(),
            'security' => Summary::active()->byCategory('security')->count(),
            'devops' => Summary::active()->byCategory('devops')->count(),
        ];
        
        return view('summaries', compact('groupedSummaries', 'categoryCounts', 'category'));
    }

    public function show($id)
    {
        $summary = Summary::findOrFail($id);
        
        return response()->json([
            'title' => $summary->getTitle(),
            'pdf_url' => $summary->getPdfUrl(),
            'id' => $summary->id
        ]);
    }

    public function servePdf($filename)
    {
        $path = storage_path('app/public/pdfs/' . $filename);
        
        if (!file_exists($path)) {
            abort(404, 'PDF file not found');
        }
        
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function view($id)
    {
        $summary = Summary::findOrFail($id);
        
        return view('simple-pdf-viewer', [
            'title' => $summary->getTitle(),
            'pdfUrl' => $summary->getPdfUrl(),
            'downloadUrl' => route('summaries.download', $summary->id)
        ]);
    }

    public function download($id)
    {
        $summary = Summary::findOrFail($id);
        $path = storage_path('app/public/pdfs/' . $summary->pdf_file_path);
        
        if (!file_exists($path)) {
            abort(404, 'PDF file not found');
        }
        
        $filename = $summary->getTitle() . '.pdf';
        
        return response()->download($path, $filename, [
            'Content-Type' => 'application/pdf'
        ]);
    }
}
