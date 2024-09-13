<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\BillingTypesRepositoryInterface;

class BillingTypesRepository extends BaseRepository implements BillingTypesRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\BillingType';
    }
}
