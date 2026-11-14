<?php

namespace Eii\WebSuite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactForm extends Model
{
    protected $table = 'contact_forms';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['fields' => 'array', 'is_active' => 'boolean', 'settings' => 'array'];
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(ContactSubmission::class, 'contact_form_id');
    }
}
