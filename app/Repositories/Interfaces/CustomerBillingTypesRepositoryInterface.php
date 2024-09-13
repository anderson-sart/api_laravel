<?php

namespace App\Repositories\Interfaces;

interface CustomerBillingTypesRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertTP($attributes, $field1, $field2);
}
