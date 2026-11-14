<?php

namespace Eii\WebSuite\Policies;

use Eii\WebSuite\Models\JobPost;
use Illuminate\Contracts\Auth\Authenticatable;

class JobPostPolicy
{
    public function viewAny(Authenticatable $user): bool
    {
        return true;
    }

    public function update(Authenticatable $user, JobPost $post): bool
    {
        return true;
    }
}
