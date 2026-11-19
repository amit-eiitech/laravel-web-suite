<?php

namespace Eii\WebSuite\Models;

use Eii\FilamentAiAssistant\Models\Concerns\HasAiAssistantContext;
use Eii\WebSuite\Enums\EmploymentType;
use Eii\WebSuite\Enums\JobPostStatus;
use Eii\WebSuite\Models\Concerns\HasSeoMetadata;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasSeoMetadata;
    use HasAiAssistantContext;

    protected $table = 'job_posts';

    protected $fillable = [
        'title',
        'slug',
        'department',
        'employment_type',
        'location',
        'salary_range',
        'description',
        'requirements',
        'application_url',
        'application_closes_at',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'requirements' => 'array',
            'employment_type' => EmploymentType::class,
            'application_closes_at' => 'datetime',
            'published_at' => 'datetime',
            'status' => JobPostStatus::class,
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
