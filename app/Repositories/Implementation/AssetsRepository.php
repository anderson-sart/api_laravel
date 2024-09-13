<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\AssetsRepositoryInterface;

class AssetsRepository extends BaseRepository implements AssetsRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\Asset';
    }
}
