<?php

namespace App\Repositories\Interfaces;

interface ProductDiscountRulesRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertP($attributes, $field1, $field2);
}
