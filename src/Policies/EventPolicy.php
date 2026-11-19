<?php

namespace Eii\WebSuite\Policies;

use Eii\WebSuite\Models\Event;
use Illuminate\Contracts\Auth\Authenticatable;

class EventPolicy
{
    public function viewAny(Authenticatable $user): bool
    {
        return true;
    }

    public function view(Authenticatable $user, Event $post): bool
    {
        return true;
    }

    public function update(Authenticatable $user, Event $post): bool
    {
        // Replace with your default rule; e.g., allow all Filament users:
        return true;
    }
}
