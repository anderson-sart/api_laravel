<?php

namespace App\Repositories\Implementation;

use App\Repositories\Interfaces\TypeSalePaymentTermsRepositoryInterface;

class TypeSalePaymentTermsRepository extends BaseRepository implements TypeSalePaymentTermsRepositoryInterface
{

    function model(): string
    {
        return 'App\Models\TypeSalePaymentTerm';
    }

    /**
     * @param $attributes
     * @param $field
     * @return mixed
     */
    public function updateInsertTP($attributes, $field1, $field2): mixed
    {

        $clauses = array(
            $field1 => $attributes[$field1],
            $field2 => $attributes[$field2]
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
