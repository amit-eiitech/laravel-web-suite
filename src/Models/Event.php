<?php

namespace Eii\WebSuite\Models;

use Eii\FilamentAiAssistant\Models\Concerns\HasAiAssistantContext;
use Eii\WebSuite\Enums\ContentStatus;
use Eii\WebSuite\Models\Concerns\HasSeoMetadata;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Event extends Model
{
    use HasSeoMetadata;
    use HasAiAssistantContext;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'location',
        'registration_url',
        'starts_at',
        'ends_at',
        'featured_image',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'status' => ContentStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable', 'categorizables');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function aiAllowedFields(): array
    {
        return [
            'title',
            'slug',
            'content',
            'excerpt',
            'location',
            'registration_url',
            'starts_at',
            'ends_at',
            'featured_image',
            'status',
            'published_at',
        ];
    }
}
