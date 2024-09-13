<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\TypeSalesRepositoryInterface;

class TypeSalesRepository extends BaseRepository implements TypeSalesRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\TypeSale';
    }
}
