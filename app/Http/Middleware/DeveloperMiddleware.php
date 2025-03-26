<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class DeveloperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = Http::withToken(getenv('APP_API_TOKEN'))
                ->get(getenv('APP_API_URL').'/Position/PositionList');
            
        $data = $response->json();
        
        $adminId = $data[2]["id"];
        
        if (auth()->check() && auth()->user()['userType'] === $adminId) {
            return $next($request);
        }
        return abort(403);
    }
}
