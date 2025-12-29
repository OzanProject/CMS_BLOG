<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Configuration;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if Maintenance Mode is ON
        $isMaintenance = Configuration::where('key', 'maintenance_mode')->value('value');
        
        if ($isMaintenance && $isMaintenance == '1') {
            
            // 2. Exclude Admin routes and Login/Logout/Register routes
            if ($request->is('admin/*') || 
                $request->is('login') || 
                $request->is('register') || 
                $request->is('logout') ||
                $request->is('lang/*')) {
                return $next($request);
            }

            // 3. Allow Admin/Writer users to bypass
            if (Auth::check() && (Auth::user()->role === 1 || Auth::user()->role === 2)) {
                return $next($request);
            }

            // 4. Show Maintenance Page
            $message = Configuration::where('key', 'maintenance_message')->value('value');
            return response()->view('errors.503', ['message' => $message], 503);
        }

        return $next($request);
    }
}
