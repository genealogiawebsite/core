<?php

namespace LaravelEnso\Core\Http\Controllers\Administration\User;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\Forms\Builders\UserForm;
use LaravelEnso\People\Models\Person;

class Create extends Controller
{
    public function __invoke(Person $person, UserForm $form)
    {

        $user = Auth::user();

        if ($user->person->id === $person->id || $user->isAdmin() || $user->isSupervisor()) {
            return ['form' => $form->create($person)];
        }

        else{
            return [
                'message' => ('You do not have permission to create user.'),
                'redirect' => 'administration.users.index',
            ];
        }
    }
}
