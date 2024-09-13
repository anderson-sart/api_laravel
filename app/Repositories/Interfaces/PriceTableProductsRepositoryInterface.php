<?php

namespace App\Repositories\Interfaces;

interface PriceTableProductsRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertP($attributes, $field1, $field2);
}
