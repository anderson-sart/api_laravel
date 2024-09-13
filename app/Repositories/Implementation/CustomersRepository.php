<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\CustomersRepositoryInterface;

class CustomersRepository extends BaseRepository implements CustomersRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\Customer';
    }
}
