<?php

namespace App\Repositories\Interfaces;

interface TypeSalePaymentTermsRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertTP($attributes, $field1, $field2);
}
