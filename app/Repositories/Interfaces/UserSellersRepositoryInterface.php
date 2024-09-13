<?php

namespace App\Repositories\Interfaces;

interface UserSellersRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertTP($attributes, $field1, $field2);
}
