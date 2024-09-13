<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\PriceTablesRepositoryInterface;

class PriceTablesRepository extends BaseRepository implements PriceTablesRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\PriceTable';
    }
}
