<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\SellersRepositoryInterface;

class SellersRepository extends BaseRepository implements SellersRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\Seller';
    }
}
