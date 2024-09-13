<?php

namespace App\Repositories\Interfaces;

interface SellerCustomersRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertTP($attributes, $field1, $field2);
}
