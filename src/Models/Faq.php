<?php

namespace Eii\WebSuite\Models;

use Eii\FilamentAiAssistant\Models\Concerns\HasAiAssistantContext;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasAiAssistantContext;

    protected $table = 'faqs';

    protected $fillable = [
        'question',
        'answer',
        'category',
        'sort_order',
        'is_published',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order');
    }

    public function aiAllowedFields(): array
    {
        return [
            'question',
            'answer',
            'category',
            'sort_order',
            'is_published',
        ];
    }
}
