<?php

namespace Eii\WebSuite\Policies;

use Eii\WebSuite\Models\Faq;
use Illuminate\Contracts\Auth\Authenticatable;

class FaqPolicy
{
    public function viewAny(Authenticatable $user): bool
    {
        return true;
    }

    public function view(Authenticatable $user, Faq $post): bool
    {
        return true;
    }

    public function update(Authenticatable $user, Faq $post): bool
    {
        // Replace with your default rule; e.g., allow all Filament users:
        return true;
    }
}
