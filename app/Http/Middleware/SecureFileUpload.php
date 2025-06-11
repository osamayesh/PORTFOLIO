<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureFileUpload
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check file uploads
        if ($request->hasFile('pdf_file') || $request->hasFile('featured_image')) {
            
            // Check PDF files
            if ($request->hasFile('pdf_file')) {
                $file = $request->file('pdf_file');
                
                // Validate file type by content, not just extension
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file->getPathname());
                finfo_close($finfo);
                
                if ($mimeType !== 'application/pdf') {
                    return response()->json(['error' => 'Invalid file type. Only PDF files are allowed.'], 422);
                }
                
                // Check file size (10MB max)
                if ($file->getSize() > 10 * 1024 * 1024) {
                    return response()->json(['error' => 'File size too large. Maximum 10MB allowed.'], 422);
                }
            }
            
            // Check image files
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                
                // Validate image MIME type
                $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file->getPathname());
                finfo_close($finfo);
                
                if (!in_array($mimeType, $allowedMimes)) {
                    return response()->json(['error' => 'Invalid image type. Only JPEG, PNG, JPG, GIF are allowed.'], 422);
                }
                
                // Check image dimensions (optional)
                $imageInfo = getimagesize($file->getPathname());
                if ($imageInfo === false) {
                    return response()->json(['error' => 'Invalid image file.'], 422);
                }
                
                // Check file size (2MB max for images)
                if ($file->getSize() > 2 * 1024 * 1024) {
                    return response()->json(['error' => 'Image size too large. Maximum 2MB allowed.'], 422);
                }
            }
        }

        return $next($request);
    }
} 