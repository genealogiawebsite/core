<?php

namespace LaravelEnso\Core\app\Policies;

use LaravelEnso\Core\app\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function handle(User $user, User $targetUser)
    {
        return $user->isAdmin() || !$targetUser->isAdmin();
    }

    public function changePassword(User $user, User $targetUser)
    {
        return $user->id === $targetUser->id;
    }

    public function changeRole(User $user, User $targetUser)
    {
        return $user->id !== $targetUser->id
            && !($targetUser->isAdmin() && !$user->isAdmin());
    }
}