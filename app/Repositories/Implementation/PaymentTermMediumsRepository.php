<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\PaymentTermMediumsRepositoryInterface;

class PaymentTermMediumsRepository extends BaseRepository implements PaymentTermMediumsRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\PaymentTermMedium';
    }
}
