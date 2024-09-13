<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\CarriersRepositoryInterface;

class CarriersRepository extends BaseRepository implements CarriersRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\Carrier';
    }
}
