<?php

namespace Eii\WebSuite\Services;

use Eii\WebSuite\Models\SeoMetadata;
use Eii\WebSuite\Settings\SeoSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SeoResolver
{
    public function resolve(Request $request): array
    {
        $record = $this->resolveRecord($request);
        $defaults = app(SeoSettings::class);

        $meta = [
            'title' => $record->title ?? $defaults->default_title ?? config('app.name'),
            'description' => $record->description ?? $defaults->default_description,
            'canonical_url' => $record->canonical_url ?? null,
            'robots' => $record->robots ?? ($defaults->allow_indexing ? [] : ['noindex']),
            'og_title' => $record->og_title ?? $record->title ?? $defaults->default_title ?? config('app.name'),
            'og_description' => $record->og_description ?? $record->description ?? $defaults->default_description,
            'og_image' => $record->og_image ?? $defaults->default_og_image,
        ];

        return [
            'record' => $record,
            'defaults' => $defaults,
            'meta' => $meta,
        ];
    }

    protected function resolveRecord(Request $request): ?SeoMetadata
    {
        $route = $request->route();

        // 1) Model-backed content: if the route parameter is a model with seoMetadata relation
        if ($route) {
            foreach ($route->parameters() as $parameter) {
                if ($parameter instanceof Model && method_exists($parameter, 'seoMetadata')) {
                    $related = $parameter->seoMetadata()->first();
                    if ($related) {
                        return $related;
                    }
                }
            }
        }

        // 2) Custom page: exact route name match
        $routeName = $route?->getName();
        if ($routeName) {
            return SeoMetadata::forRouteName($routeName)->first();
        }

        return null;
    }
}
