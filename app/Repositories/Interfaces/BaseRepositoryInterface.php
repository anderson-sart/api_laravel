<?php

namespace App\Repositories\Interfaces;

use App\Filters\QueryFilters;

interface BaseRepositoryInterface
{
    public function all($columns = ['*']);

    public function allTrashed($columns = ['*']);

    public function paginate($total = 30, $columns = ['*']);

    public function paginateByCriteria($criteria, $total = 30, $columns = ['*']);

    public function create($attributes);

    public function update($attributes, $id);

    public function updateInsert($attributes, $field);

    public function deleteId($id);
    
    public function inactivateAllAll();

    public function find($id, $columns = ['*']);

    public function findBy($criteria, $columns = ['*'], $relations = null);

    public function findBy2($criteria, $whereClauses2 = [], $columns = ['*'], $relations = null);

    public function listBy($criteria, array $columns = ['*'], string $orderByClause = null, string $orderByType = null, $relations = null);

    public function filterWithPagination(
        QueryFilters $filters, $columns, $total = 30, $relations = null,
        string $orderByClause = null, string $orderByType = null, $criteria = array()
    );

    public function filter(QueryFilters $filters, $columns, $userId = null, $relations = null);

    public function listByDias(QueryFilters $filters, $criteria, array $columns = ['*'], string $orderByClause = null, string $orderByType = null, $relations = null, $diasFiltro = null, $statusIN = null);

}
