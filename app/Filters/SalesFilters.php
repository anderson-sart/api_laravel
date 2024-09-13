<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Utils\DateUtils;

class SalesFilters extends QueryFilters
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function saleCode(string $term): Builder
    {
        return $this->builder->where('sales.sale_code', 'LIKE', "%$term%");
    }
    public function status(string $term = ""): Builder
    {
        $term = strtoupper($term);
        if($term){
            return $this->builder->where('sales.status', '=', "$term" );
        }else{
            return $this->builder;
        }
    }
    public function user_id(int $term = null): Builder
    {
       if($term){
            return $this->builder->where('sales.user_id', '=', "$term" );
        }else{
            return $this->builder;
        }
    }
    
    
    public function search(string $term = ""): Builder
    {
        if($term){
            return $this->builder->where('sales.sale_code', 'LIKE', "%{$term}%")
                            ->orWhere('id', 'LIKE', "%{$term}%") // Adding the id filter
                            ->orWhereHas('saleItems', function ($q) use ($term) {
                                $q->where('sale_items.delivery_date', 'LIKE', "%{$term}%");
                            })
                            ->orWhereHas('seller', function ($q) use ($term) {
                                $q->where('sellers.corporate_name', 'LIKE', "%{$term}%");
                            })
                            ->orWhereHas('user', function ($q) use ($term) {
                                $q->where('users.name', 'LIKE', "%{$term}%");
                            });
        }else{
            return $this->builder;
        }
    }

    public function username(string $term): Builder
    {
        if ($term) {
      
            $term = strtoupper($term);
            return $this->builder->whereHas('user', function ($q) use ($term) {
                                        $q->where('users.name', '=', $term);
                                     });
        }
    
        // Retorne o builder original ou algo padrão se o $term não for fornecido.
        return $this->builder;
    }

    public function databaseId(string $term): Builder
    {
        if ($term) {
          
    
            return $this->builder->where('sales.database_id', '!=', $term);
        }
    
        // Retorne o builder original ou algo padrão se o $term não for fornecido.
        return $this->builder;
    }
}
