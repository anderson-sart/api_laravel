<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\SaleDeliveryPeriodsRepositoryInterface;

class SaleDeliveryPeriodsRepository extends BaseRepository implements SaleDeliveryPeriodsRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\SaleDeliveryPeriod';
    }
}
