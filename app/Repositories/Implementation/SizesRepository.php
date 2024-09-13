<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\SizesRepositoryInterface;

class SizesRepository extends BaseRepository implements SizesRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\Size';
    }
}
