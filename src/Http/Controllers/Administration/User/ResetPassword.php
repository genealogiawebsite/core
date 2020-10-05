<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use LaravelEnso\Core\Models\User;

class ResetPassword extends Controller
{
    use AuthorizesRequests;

    public function __invoke(User $user)
    {
        $auth = Auth::user();

        if ($user->id === $auth->id || $user->isAdmin() || $user->isSupervisor()) {


            $this->authorize('reset-password', $user);

            Password::broker()->sendResetLink($user->only('email'));

            return [
                'message' => __('We have e-mailed password reset link!'),
            ];

        }

        else{
            return [
                'message' => ('You do not have permission to reset this user password.'),
                'redirect' => 'administration.users.index',
            ];
        }
    }
}
