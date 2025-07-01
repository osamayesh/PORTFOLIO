<?php

namespace App\Helpers;

class SecurityHelper
{
    /**
     * Sanitize HTML content while preserving safe tags
     */
    public static function sanitizeHtml($content)
    {
        // Allow only safe HTML tags
        $allowedTags = '<p><br><strong><b><em><i><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><img><pre><code><blockquote>';
        
        return strip_tags($content, $allowedTags);
    }
    
    /**
     * Clean string input
     */
    public static function cleanString($input)
    {
        if (!is_string($input)) {
            return $input;
        }
        
        // Remove null bytes
        $input = str_replace(chr(0), '', $input);
        
        // Trim whitespace
        $input = trim($input);
        
        // Remove control characters except tab, newline, carriage return
        $input = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $input);
        
        return $input;
    }
    
    /**
     * Validate and sanitize URL
     */
    public static function sanitizeUrl($url)
    {
        $url = filter_var($url, FILTER_SANITIZE_URL);
        
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        
        // Only allow http and https protocols
        $parsed = parse_url($url);
        if (!in_array($parsed['scheme'] ?? '', ['http', 'https'])) {
            return false;
        }
        
        return $url;
    }
    
    /**
     * Generate secure filename
     */
    public static function generateSecureFilename($originalName, $extension = null)
    {
        // Remove path information and decode entities
        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        $filename = html_entity_decode($filename, ENT_QUOTES, 'UTF-8');
        
        // Remove or replace dangerous characters
        $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $filename);
        
        // Limit length
        $filename = substr($filename, 0, 100);
        
        // Add timestamp to avoid conflicts
        $filename .= '_' . time();
        
        // Add extension if provided
        if ($extension) {
            $filename .= '.' . $extension;
        }
        
        return $filename;
    }
    
    /**
     * Check if string contains SQL injection patterns
     */
    public static function detectSqlInjection($input)
    {
        $patterns = [
            // Basic SQL commands
            '/(\bunion\b.*\bselect\b)/i',
            '/(\bselect\b.*\bfrom\b)/i',
            '/(\binsert\b.*\binto\b)/i',
            '/(\bupdate\b.*\bset\b)/i',
            '/(\bdelete\b.*\bfrom\b)/i',
            '/(\bdrop\b.*\btable\b)/i',
            '/(\balter\b.*\btable\b)/i',
            '/(\bcreate\b.*\btable\b)/i',
            '/(\btruncate\b.*\btable\b)/i',
            
            // Advanced injection patterns
            '/(\bexec\b.*\b)/i',
            '/(\bexecute\b.*\b)/i',
            '/(\bsp_\w+)/i',
            '/(\bxp_\w+)/i',
            
            // Comment patterns
            '/(\/\*.*\*\/)/i',
            '/(\-\-)/i',
            '/(#)/i',
            
            // Common injection strings
            '/(\bor\b.*\b1\s*=\s*1)/i',
            '/(\band\b.*\b1\s*=\s*1)/i',
            '/(\bor\b.*\btrue\b)/i',
            '/(\bor\b.*\b1\b)/i',
            '/(\bunion\b.*\ball\b)/i',
            
            // Hex and char injections
            '/(0x[0-9a-f]+)/i',
            '/(\bchar\b.*\()/i',
            '/(\bcast\b.*\()/i',
            '/(\bconvert\b.*\()/i',
            
            // Script and dangerous functions
            '/(\bscript\b.*\b)/i',
            '/(\bjavascript\b.*\b)/i',
            '/(\bvbscript\b.*\b)/i',
            
            // Information schema attacks
            '/(\binformation_schema\b)/i',
            '/(\bsys\b.*\btables\b)/i',
            '/(\bmysql\b.*\buser\b)/i',
            
            // Time-based injection
            '/(\bsleep\b.*\()/i',
            '/(\bwaitfor\b.*\bdelay\b)/i',
            '/(\bbenchmark\b.*\()/i',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Check if string contains XSS patterns
     */
    public static function detectXss($input)
    {
        $patterns = [
            '/<script[^>]*>.*?<\/script>/is',
            '/<iframe[^>]*>.*?<\/iframe>/is',
            '/javascript:/i',
            '/vbscript:/i',
            '/onload=/i',
            '/onerror=/i',
            '/onclick=/i',
            '/onmouseover=/i',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }
        
        return false;
    }
} 