<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\UsersRepositoryInterface;

class UsersRepository extends BaseRepository implements UsersRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\User';
    }
}
