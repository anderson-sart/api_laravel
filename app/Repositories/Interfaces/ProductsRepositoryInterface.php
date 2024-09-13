<?php

namespace App\Repositories\Interfaces;

interface ProductsRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertP($attributes, $field1, $field2, $field3, $field4);
}
