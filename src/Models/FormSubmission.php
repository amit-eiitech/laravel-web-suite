<?php

namespace Eii\WebSuite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormSubmission extends Model
{
    protected $table = 'form_submissions';

    protected $fillable = [
        'form_id',
        'data',
        'status',
        'ip_hash',
        'handled_at',
    ];

    protected function casts(): array
    {
        return ['data' => 'array', 'handled_at' => 'datetime'];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
