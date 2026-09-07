<?php

namespace App\Http\Middleware;

use App\Services\VisitorTrackerService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackWebsiteVisitor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful or redirecting GET requests
        if ($request->isMethod('GET') && $response->getStatusCode() < 400) {
            VisitorTrackerService::track($request);
        }

        return $response;
    }
}
