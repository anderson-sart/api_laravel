<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompaniesFilter extends QueryFilters
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function name(string $term): Builder
    {   
        $term = strtoupper($term);
        return $this->builder->whereHas('users', function ($query) use ($term) {
            $query->where(DB::raw('upper(users.username)') , 'LIKE', "%$term%")
            ->orWhere(DB::raw('upper(users.name)') , 'LIKE', "%$term%");
        })->orWhere(DB::raw('upper(companies.company_name)') , 'LIKE', "%$term%")
        ->orWhere(DB::raw('upper(companies.name_to_follow)') , 'LIKE', "%$term%");
    }

}
