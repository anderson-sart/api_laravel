<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\BrandsRepositoryInterface;

class BrandsRepository extends BaseRepository implements BrandsRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\Brand';
    }
}
