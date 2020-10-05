<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\Models\User;
use LaravelEnso\Core\Services\ProfileBuilder;

class Show extends Controller
{
    public function __invoke(User $user)
    {

        $auth = Auth::user();

        if ($user->id === $auth->id || $user->isAdmin() || $user->isSupervisor()) {
            (new ProfileBuilder($user))->set();

            return ['user' => $user];
        }

        else{
            return [
                'message' => ('You do not have permission to edit this user.'),
                'redirect' => 'administration.users.index',
            ];
        }
    }
}
