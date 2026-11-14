<?php

namespace Eii\WebSuite\Http\Middleware;

use Closure;
use Eii\WebSuite\Services\SeoResolver;
use Illuminate\Http\Request;

class ResolveSeoMetadata
{
    public function __construct(protected SeoResolver $resolver)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $resolved = $this->resolver->resolve($request);

        // Make available to all views
        view()->share('seoMetadata', $resolved['record']);
        view()->share('seoDefaults', $resolved['defaults']);
        view()->share('seoMeta', $resolved['meta']);

        return $next($request);
    }
}
