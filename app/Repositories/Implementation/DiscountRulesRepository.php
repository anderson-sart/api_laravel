<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\DiscountRulesRepositoryInterface;

class DiscountRulesRepository extends BaseRepository implements DiscountRulesRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\DiscountRule';
    }

    /**
     * @param $attributes
     * @param $field
     * @return mixed
     */
    public function updateInsertP($attributes, $field1, $field2, $field3): mixed
    {

        $clauses = array(
            $field1 => $attributes[$field1],
            $field2 => $attributes[$field2],
            $field2 => $attributes[$field3]
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
