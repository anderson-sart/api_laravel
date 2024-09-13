<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\PaymentTermsRepositoryInterface;

class PaymentTermsRepository extends BaseRepository implements PaymentTermsRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\PaymentTerm';
    }
}
