<?php

namespace Eii\WebSuite\Http\Middleware;

use BackedEnum;
use Closure;
use Eii\WebSuite\Models\SeoRedirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        if (config('app.debug')) {
            Log::debug('web-suite.seo.redirect: inspecting request', [
                'method' => $request->method(),
                'path_info' => $pathInfo,
                'variants' => $variants,
            ]);
        }

        $redirect = SeoRedirect::query()
            ->where('is_active', true)
            ->where(function ($query) use ($variants) {
                foreach ($variants as $variant) {
                    $query->orWhere('source_path', $variant);
                }
            })
            ->first();

        if (! $redirect) {
            if (config('app.debug')) {
                Log::debug('web-suite.seo.redirect: no matching redirect found', [
                    'variants' => $variants,
                ]);
            }

            return $next($request);
        }

        $statusCode = $redirect->status_code instanceof BackedEnum
            ? $redirect->status_code->value
            : (int) $redirect->status_code;

        if (config('app.debug')) {
            Log::debug('web-suite.seo.redirect: redirect matched', [
                'source_path' => $redirect->source_path,
                'destination_url' => $redirect->destination_url,
                'status_code' => $statusCode,
            ]);
        }

        if ($statusCode === 410) {
            abort(410);
        }

        return redirect($redirect->destination_url, $statusCode);
    }
}
