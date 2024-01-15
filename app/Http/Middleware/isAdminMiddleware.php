<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class isAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $role = optional($user->role);

        // Log user and role information for debugging
        Log::debug("User {$user->name} (ID: {$user->id}) has role: {$role->name} (ID: {$role->id})");

        if ($role->name !== 'admin') {//
            return redirect()->back()->with('errorAlert', 'Admin! You are not authorized to access this page');
        }

        return $next($request);
    }
    
}
