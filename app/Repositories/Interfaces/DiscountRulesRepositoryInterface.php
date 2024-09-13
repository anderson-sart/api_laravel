<?php

namespace App\Repositories\Interfaces;

interface DiscountRulesRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertP($attributes, $field1, $field2, $field3);
}
