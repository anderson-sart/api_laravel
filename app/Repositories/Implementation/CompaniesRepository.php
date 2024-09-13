<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\CompaniesRepositoryInterface;

class CompaniesRepository extends BaseRepository implements CompaniesRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\Company';
    }
}
