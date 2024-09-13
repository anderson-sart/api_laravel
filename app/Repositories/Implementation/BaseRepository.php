<?php

namespace App\Repositories\Implementation;

use App\Filters\QueryFilters;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Carbon\Carbon;

abstract class BaseRepository implements BaseRepositoryInterface
{

    private App $app;

    protected Model $model;

    function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify the model class name
     */
    abstract function model();

    /**
     * Instantiate the model
     * @return Model
     * @throws Exception
     */
    public function makeModel(): Model
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']): mixed
    {
        return $this->model->get($columns);
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function allTrashed($columns = ['*']): mixed
    {
        return $this->model->withTrashed()
            ->whereNull('deleted_at')
            ->get($columns);
    }

    /**
     * @param int $total
     * @param array $columns
     * @return mixed
     */
    public function paginate($total = 15, $columns = ['*']): mixed
    {
        return $this->model->paginate($total, $columns);
    }

    public function paginateByCriteria($criteria, $total = 30, $columns = ['*'])
    {
        $whereClauses = [];
        foreach ($criteria as $key => $value) {
            $whereClauses[] = [$key , '=' , $value];
        }

        return $this->model->where($whereClauses)->paginate($total, $columns);
    }

    /**
     * @param $attributes
     * @return mixed
     */
    public function create($attributes): mixed
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $attributes
     * @param $id
     * @return mixed
     */
    public function update($attributes, $id): mixed
    {
        $obj = $this->find($id);

        if (is_null($obj)) {
            return null;
        }

        $obj->fill($attributes);

        return $obj->save();
    }

        /**
     * @param $attributes
     * @param $field
     * @return mixed
     */
    public function updateInsert($attributes, $field): mixed
    {

        $clauses = array($field => $attributes[$field]);
        $arrayT = $this->findBy($clauses);
       
        if (is_null($arrayT)) {
            unset($attributes['id']);
            $attributes['status'] = 'A';
            return $this->model->create($attributes);
        }else{
            $attributes['status'] = 'A';
            $arrayT->fill($attributes);
            return $arrayT->save();
           
           
        }

    }

    /**
     * @param $id
     * @return int
     */
    public function deleteId($id): int
    {
        return $this->model->destroy($id);
    }

    /**
     */
    public function inactivateAllAll()
    {
        return $this->model->query()->update(['status' => 'I']);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']): mixed
    {

        return $this->model->find($id, $columns);
    }

    /**
     * @param $criteria
     * @param array $columns
     * @return mixed
     */
    public function findBy($criteria, $columns = ['*'], $relations = null): mixed
    {
        $whereClauses = [];
        foreach ($criteria as $key => $value) {
            $whereClauses[] = [$key , '=' , $value];
        }

        return $this->model
            ->when(!is_null($relations), function ($query) use ($relations) {
                $query->with($relations);
            })
            ->where($whereClauses)
            ->first($columns);
    }

        /**
     * @param $criteria
     * @param $criteria2
     * @param array $columns
     * @return mixed
     */
    public function findBy2($criteria, $whereClauses2 = [] ,$columns = ['*'], $relations = null): mixed
    {
        $whereClauses = [];
        foreach ($criteria as $key => $value) {
            $whereClauses[] = [$key , '=' , $value];
        }

        return $this->model
            ->when(!is_null($relations), function ($query) use ($relations) {
                $query->with($relations);
            })
            ->where($whereClauses)
            ->where($whereClauses2)
            ->first($columns);
    }

    /**
     * Lista os recursos pelos critérios de busca
     * @param $criteria
     * @param array $columns
     * @return mixed
     */
    public function listBy($criteria, array $columns = ['*'], string $orderByClause = null, string $orderByType = null, $relations = null): mixed
    {
        $whereClauses = [];
        foreach ($criteria as $key => $value) {
            $whereClauses[] = [$key , '=' , $value];
        }

        return $this->model->where($whereClauses)
            ->when(!is_null($relations), function ($query) use ($relations) {
                $query->with($relations);
            })
            ->when(!is_null($orderByClause) && !is_null($orderByType), function ($query) use ($orderByClause, $orderByType) {
                $query->orderBy($orderByClause, $orderByType);
            })
            ->get($columns);
    }



    public function filterWithPagination(
        QueryFilters $filters, $columns, $total = 30, $relations = null,
        string $orderByClause = null, string $orderByType = null, $criteria = array()
    ) {
        $whereClauses = [];
        foreach ($criteria as $key => $value) {
            $whereClauses[] = [$key , '=' , $value];
        }

        return $this->model->where($whereClauses)
            ->when(!is_null($relations), function ($query) use ($relations) {
                $query->with($relations);
            })
            ->filter($filters)
            ->when(!is_null($orderByClause) && !is_null($orderByType), function ($query) use ($orderByClause, $orderByType) {
                $query->orderBy($orderByClause, $orderByType);
            })
            ->paginate($total, $columns);
    }

    public function filter(QueryFilters $filters, $columns, $userId = null, $relations = null)
    {
        return $this->model
            ->when(!is_null($relations), function ($query) use ($relations) {
                $query->with($relations);
            })
            ->when(!is_null($userId), function ($query) use ($userId) {
                $query->where($this->model->getTable().'.user_id', $userId);
            })
            ->filter($filters)
            ->get($columns);
    }

    public function listByDias(QueryFilters $filters, $criteria, array $columns = ['*'], string $orderByClause = null, string $orderByType = null, $relations = null, $diasFiltro = null, $statusIN = null)
    {
        $whereClauses = [];
        if (!is_null($criteria)) {
            foreach ($criteria as $key => $value) {
                $whereClauses[] = [$key , '=' , $value];
            }
        }
       
        $date = Carbon::now()->subDays($diasFiltro);
    
        return $this->model->where($whereClauses)
            ->whereDate('created_at', '>=', $date)
            ->whereIn('status', $statusIN)
            ->when(!is_null($relations), function ($query) use ($relations) {
                $query->with($relations);
            })
            ->when(!is_null($orderByClause) && !is_null($orderByType), function ($query) use ($orderByClause, $orderByType) {
                $query->orderBy($orderByClause, $orderByType);
            })
            ->filter($filters)
            ->get($columns);
    }
}
