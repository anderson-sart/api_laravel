<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\SalesRepositoryInterface;

class SalesRepository extends BaseRepository implements SalesRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\Sale';
    }
}
