<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\SecurityHelper;
use Illuminate\Support\Facades\Log;

class SqlInjectionProtection
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip protection for static assets
        if ($this->isStaticAsset($request)) {
            return $next($request);
        }
        
        // Skip protection for admin panel (it has its own CSRF protection)
        if ($request->is('admin/*')) {
            return $next($request);
        }
        
        // Only check forms and search inputs, not all requests
        if (!$this->shouldCheckRequest($request)) {
            return $next($request);
        }
        
        // Check all input for SQL injection patterns
        $inputs = $request->all();
        
        foreach ($inputs as $key => $value) {
            if (is_string($value) && $this->isRealSqlInjection($value)) {
                // Log the attempt
                Log::warning('SQL Injection attempt detected', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url' => $request->fullUrl(),
                    'input_field' => $key,
                    'suspicious_value' => substr($value, 0, 100), // Limit log size
                    'timestamp' => now()
                ]);
                
                // Redirect back with error instead of JSON for web requests
                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => 'Suspicious input detected. Request blocked for security reasons.',
                        'code' => 'SQL_INJECTION_DETECTED'
                    ], 403);
                } else {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['security' => 'Suspicious input detected. Please review your input and try again.']);
                }
            }
        }

        return $next($request);
    }
    
    /**
     * Check if request is for static assets
     */
    private function isStaticAsset(Request $request): bool
    {
        $path = $request->path();
        $staticExtensions = [
            'css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'ico', 'svg', 
            'woff', 'woff2', 'ttf', 'eot', 'pdf', 'zip', 'rar'
        ];
        
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return in_array(strtolower($extension), $staticExtensions);
    }
    
    /**
     * Check if request should be protected
     */
    private function shouldCheckRequest(Request $request): bool
    {
        // Only check POST, PUT, PATCH requests and GET with search/filter parameters
        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('patch')) {
            return true;
        }
        
        // Check GET requests with specific parameters that could be vulnerable
        $dangerousParams = ['search', 'filter', 'sort', 'q', 'query', 'term'];
        foreach ($dangerousParams as $param) {
            if ($request->has($param)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * More sophisticated SQL injection detection
     */
    private function isRealSqlInjection(string $value): bool
    {
        // Skip very short strings
        if (strlen($value) < 3) {
            return false;
        }
        
        // Skip if it's just a hyphen or normal text
        if (preg_match('/^[\w\s\-_.@]+$/', $value)) {
            return false;
        }
        
        // Check for actual SQL injection patterns
        $patterns = [
            // Union-based injection
            '/(\bunion\s+select\b)/i',
            '/(\bunion\s+all\s+select\b)/i',
            
            // Boolean-based injection
            '/(\bor\s+1\s*=\s*1\b)/i',
            '/(\band\s+1\s*=\s*1\b)/i',
            '/(\bor\s+true\b)/i',
            
            // Comment injection
            '/(\/\*.*?\*\/)/i',
            '/(\-\-\s)/i',
            '/(#\s)/i',
            
            // Function calls that are dangerous
            '/(\bexec\s*\()/i',
            '/(\bsp_\w+)/i',
            '/(\bxp_\w+)/i',
            '/(\bdrop\s+table\b)/i',
            '/(\bdelete\s+from\b)/i',
            '/(\binsert\s+into\b)/i',
            '/(\bupdate\s+\w+\s+set\b)/i',
            
            // Information gathering
            '/(\binformation_schema\b)/i',
            '/(\bmysql\s*\.\s*user\b)/i',
            
            // Time-based injection
            '/(\bsleep\s*\()/i',
            '/(\bwaitfor\s+delay\b)/i',
            '/(\bbenchmark\s*\()/i',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return true;
            }
        }
        
        return false;
    }
} 