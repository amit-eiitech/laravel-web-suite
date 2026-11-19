<?php

namespace Eii\WebSuite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMetadata extends Model
{
    protected $table = 'seo_metadata';

    protected $fillable = [
        'seoable_type',
        'seoable_id',
        'route_name',
        'title',
        'description',
        'canonical_url',
        'robots',
        'og_title',
        'og_description',
        'og_image',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeForRouteName($query, string $routeName)
    {
        return $query->where('route_name', $routeName);
    }

    public function getTargetLabelAttribute(): string
    {
        if ($this->route_name && ! $this->seoable_type) {
            return 'Custom Page';
        }

        $map = [
            '\\Eii\\WebSuite\\Models\\News' => 'News',
            '\\Eii\\WebSuite\\Models\\Event' => 'Event',
            '\\Eii\\WebSuite\\Models\\JobPost' => 'Recruitment',
            '\\Eii\\WebSuite\\Models\\BlogPost' => 'Blog',
            '\\Eii\\WebSuite\\Models\\Faq' => 'FAQ',
        ];

        if ($this->seoable_type) {
            return $map[$this->seoable_type] ?? class_basename($this->seoable_type);
        }

        return '—';
    }

    protected function casts(): array
    {
        return ['robots' => 'array'];
    }
}
