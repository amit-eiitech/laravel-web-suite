<?php

namespace Eii\WebSuite\Http\Middleware;

use Closure;
use Eii\WebSuite\Models\SeoRedirect;
use Illuminate\Http\Request;

class HandleSeoRedirects
{
    public function handle(Request $request, Closure $next)
    {
        if (! in_array($request->method(), ['GET', 'HEAD'])) {
            return $next($request);
        }

        // Normalize the incoming path and match common variants (with/without leading or trailing slash)
        $pathInfo = $request->getPathInfo(); // already excludes query string
        $normalized = '/' . ltrim($pathInfo, '/');
        $normalized = $normalized === '//' ? '/' : $normalized;

        $variants = array_values(array_filter(array_unique([
            $pathInfo,
            $normalized,
            ltrim($normalized, '/'),
            rtrim($normalized, '/'),
            ltrim(rtrim($normalized, '/'), '/'),
        ])));

        $redirect = SeoRedirect::query()
            ->where('is_active', true)
            ->where(function ($query) use ($variants) {
                foreach ($variants as $variant) {
                    $query->orWhere('source_path', $variant);
                }
            })
            ->first();

        if (! $redirect) {
            return $next($request);
        }

        if ($redirect->status_code === 410) {
            abort(410);
        }

        return redirect($redirect->destination_url, $redirect->status_code);
    }
}
