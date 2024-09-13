<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\CustomerBillingTypesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerBillingTypesController extends Controller
{
    private CustomerBillingTypesRepositoryInterface $repository;

    private array $columns = [
        'billing_type', 
        'customer'    
    ];

    public function __construct(CustomerBillingTypesRepositoryInterface $repository)
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
        foreach ($data as $CustomerBillingTypeData) {
      
            $this->repository->updateInsertTP($CustomerBillingTypeData, 'billing_type', 'customer');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}