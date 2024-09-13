<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\SaleItemsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SaleItemsRepository extends BaseRepository implements SaleItemsRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\SaleItem';
    }

    public function saleItemQ(int $saleId )
    {
        return $this->model
            ->join('sale_delivery_periods', function ($join) {
                $join->on(DB::raw('coalesce(sale_items.delivery_date, current_date)'), '>=', 'sale_delivery_periods.initial_date')
                     ->on(DB::raw('coalesce(sale_items.delivery_date, current_date)'), '<=', 'sale_delivery_periods.final_date');
            })
            ->where('sale_items.sale_id', $saleId)
            ->distinct()
            ->select('sale_delivery_periods.*')
            ->get();
    }

    public function listPeriod(int $saleId, string $startDate, string $endDate)
    {
        $relations = array(
            'product'
        );
        return $this->model
            ->where('sale_id', $saleId)
            ->when(!is_null($relations), function ($query) use ($relations) {
                $query->with($relations);
            })
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereRaw('coalesce(delivery_date, current_date()) between ? and ?', [$startDate, $endDate]);
            })
            ->get();
    }
}
