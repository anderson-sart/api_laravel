<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\StocksRepositoryInterface;

class StocksRepository extends BaseRepository implements StocksRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\Stock';
    }

    /**
     * @param $attributes
     * @param $field
     * @return mixed
     */
    public function updateInsertP($attributes, $field1, $field2, $field3, $field4): mixed
    {

        $clauses = array(
            $field1 => $attributes[$field1],
            $field2 => $attributes[$field2],
            $field3 => $attributes[$field3],
            $field4 => $attributes[$field4]
        );
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
}
