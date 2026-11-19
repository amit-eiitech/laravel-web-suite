<?php

namespace Eii\WebSuite\Policies;

use Eii\WebSuite\Models\BlogPost;
use Illuminate\Contracts\Auth\Authenticatable;

class BlogPostPolicy
{
    public function viewAny(Authenticatable $user): bool
    {
        return true;
    }

    public function view(Authenticatable $user, BlogPost $post): bool
    {
        return true;
    }

    public function update(Authenticatable $user, BlogPost $post): bool
    {
        // Replace with your default rule; e.g., allow all Filament users:
        return true;
    }
}
