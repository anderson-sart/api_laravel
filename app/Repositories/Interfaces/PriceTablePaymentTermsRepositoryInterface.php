<?php

namespace App\Repositories\Interfaces;

interface PriceTablePaymentTermsRepositoryInterface extends BaseRepositoryInterface
{
    public function updateInsertTP($attributes, $field1, $field2);
}
