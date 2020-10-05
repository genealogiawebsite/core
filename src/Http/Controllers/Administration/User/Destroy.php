<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Core\Models\User;

class Destroy extends Controller
{
    use AuthorizesRequests;

    public function __invoke(Request $request, User $user)
    {
        if ($user->isAdmin() || $user->isSupervisor()) {


            $this->authorize('handle', $user);

            $user->erase($request->boolean('person'));

            return [
                'message' => __('The user was successfully deleted'),
                'redirect' => 'administration.users.index',
            ];

        }

        else{
            return [
                'message' => ('You do not have permission to delete this user.'),
                'redirect' => 'administration.users.index',
            ];
        }
    }
}
