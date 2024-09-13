<?php

namespace App\Repositories\Interfaces;

interface SaleItemsRepositoryInterface extends BaseRepositoryInterface
{
    public function saleItemQ(int $saleId);

    public function listPeriod(int$saleId, string $startDate, string $endDate);
}
