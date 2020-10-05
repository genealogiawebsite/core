<?php

namespace LaravelEnso\Core\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Core\Models\User;
use LaravelEnso\Tables\Contracts\Table;

class UserTable implements Table
{
    protected const TemplatePath = __DIR__.'/../Templates/users.json';

    protected $query;

    public function query(): Builder
    {

        $auth = Auth::user();

        if ($auth->isAdmin()) {


            return User::with('person:id,appellative,name', 'avatar:id,user_id')
                ->selectRaw('
                users.id, user_groups.name as "group", people.name, people.appellative,
                people.phone, users.email, roles.name as role, users.is_active,
                users.created_at, users.person_id
        ')->join('people', 'users.person_id', '=', 'people.id')
                ->join('user_groups', 'users.group_id', '=', 'user_groups.id')
                ->join('roles', 'users.role_id', '=', 'roles.id');
        } else {
            return User::where('users.id', $auth->id)
                ->with('person:id,appellative,name', 'avatar:id,user_id')
                ->selectRaw('
                users.id, user_groups.name as "group", people.name, people.appellative,
                people.phone, users.email, roles.name as role, users.is_active,
                users.created_at, users.person_id
        ')->join('people', 'users.person_id', '=', 'people.id')
                ->join('user_groups', 'users.group_id', '=', 'user_groups.id')
                ->join('roles', 'users.role_id', '=', 'roles.id');
        }
    }



    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
