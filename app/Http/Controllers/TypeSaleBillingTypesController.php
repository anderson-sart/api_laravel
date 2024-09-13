<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\TypeSaleBillingTypesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeSaleBillingTypesController extends Controller
{
    private TypeSaleBillingTypesRepositoryInterface $repository;

    private array $columns = [
        'type_sale', 
        'billing_type'
    ];

    public function __construct(TypeSaleBillingTypesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): JsonResponse
    {
        //listBy statua
        $criteria = array('status' => 'A');
        $itensData = $this->repository->listBy($criteria, $this->columns);

        $arrayRetorno = array();       
        $arrayRetorno['code'] = 200;
        $arrayRetorno['data'] = $itensData;
        return response()->json($arrayRetorno);    
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $this->repository->inactivateAllAll();
        foreach ($data as $TypeSaleBillingTypeData) {
      
            $this->repository->updateInsertTP($TypeSaleBillingTypeData, 'type_sale', 'billing_type');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}