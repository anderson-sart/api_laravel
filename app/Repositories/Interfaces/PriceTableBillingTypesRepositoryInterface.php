<?php

namespace App\Repositories\Interfaces;

interface PriceTableBillingTypesRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertTP($attributes, $field1, $field2);
}
