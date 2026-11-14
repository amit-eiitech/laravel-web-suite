<?php

namespace Eii\WebSuite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactSubmission extends Model
{
    protected $table = 'contact_submissions';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['data' => 'array', 'handled_at' => 'datetime'];
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(ContactForm::class, 'contact_form_id');
    }
}
