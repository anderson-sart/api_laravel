<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->header('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', $request->header('Origin'));
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers',  'Content-Type, Accept, Authorization, X-Requested-With, Application');

        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Connectionn', 'keep-alive');
        $response->headers->set('Content-Security-Policy', "default-src 'self';base-uri 'self';font-src 'self' https: data:;form-action 'self';frame-ancestors 'self';img-src 'self' data:;object-src 'none';script-src 'self';script-src-attr 'none';style-src 'self' https: 'unsafe-inline';upgrade-insecure-requests");
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');
        $response->headers->set('X-Xss-Protection', '0');

        return $response;
    }
}
