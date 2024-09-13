<?php

namespace App\Repositories\Interfaces;

interface PaymentTermBillingTypesRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertTP($attributes, $field1, $field2);
}
