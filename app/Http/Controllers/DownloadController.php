<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Download the CV file
     */
    public function downloadCV()
    {
        $filePath = storage_path('app/public/pdfs/Osama Ayesh_CV.pdf');
        
        if (!file_exists($filePath)) {
            abort(404, 'CV file not found');
        }
        
        return response()->download($filePath, 'Osama_Ayesh_CV.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
} 