<?php

namespace App\Policies;

use App\User;
use App\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function viewAll(User $user)
    {
        return $user->isAdministrator();
    }

    public function modify(User $user, Event $event)
    {
        return $user->isAdministrator() || $user->id == $event->user_id;
    }
}
