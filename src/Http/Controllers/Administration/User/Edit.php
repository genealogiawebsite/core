<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\Forms\Builders\UserForm;
use LaravelEnso\Core\Models\User;

class Edit extends Controller
{
    public function __invoke(User $user, UserForm $form)
    {

        $auth = Auth::user();

        if ($user->id === $auth->id || $auth->isAdmin()) {
            return ['form' => $form->edit($user)];
        }

        else{
            return [
                'message' => ('You do not have permission to edit this user.'),
                'redirect' => 'administration.users.index',
            ];
        }
    }
}
