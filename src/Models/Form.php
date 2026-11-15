<?php

namespace Eii\WebSuite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    protected $table = 'forms';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['fields' => 'array', 'is_active' => 'boolean', 'settings' => 'array'];
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class, 'form_id');
    }
}
