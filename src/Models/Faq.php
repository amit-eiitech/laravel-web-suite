<?php

namespace Eii\WebSuite\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
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
