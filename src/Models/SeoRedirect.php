<?php

namespace Eii\WebSuite\Models;

use Eii\WebSuite\Enums\SeoRedirectStatus;
use Illuminate\Database\Eloquent\Model;

class SeoRedirect extends Model
{
    protected $table = 'seo_redirects';

    protected $fillable = [
        'source_path',
        'destination_url',
        'status_code',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'status_code' => SeoRedirectStatus::class,
        ];
    }
}
