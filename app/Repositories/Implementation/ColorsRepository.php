<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\ColorsRepositoryInterface;

class ColorsRepository extends BaseRepository implements ColorsRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\Color';
    }
}
