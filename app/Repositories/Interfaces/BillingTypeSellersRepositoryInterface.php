<?php

namespace App\Repositories\Interfaces;

interface BillingTypeSellersRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertTP($attributes, $field1, $field2);
}
