<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Security Headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN'); // Prevent Clickjacking (iframe embedding from other sites)
        $response->headers->set('X-XSS-Protection', '1; mode=block'); // Cross-site scripting (XSS) filter
        $response->headers->set('X-Content-Type-Options', 'nosniff'); // Prevent MIME type sniffing
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin'); // Controls how much referrer info is sent

        return $response;
    }
}
