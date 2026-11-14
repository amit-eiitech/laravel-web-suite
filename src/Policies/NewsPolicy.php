<?php

namespace Eii\WebSuite\Policies;

use Eii\WebSuite\Models\News;
use Illuminate\Contracts\Auth\Authenticatable;

class NewsPolicy
{
    public function viewAny(Authenticatable $user): bool
    {
        return true;
    }

    public function update(Authenticatable $user, News $post): bool
    {
        // Replace with your default rule; e.g., allow all Filament users:
        return true;
    }
}
