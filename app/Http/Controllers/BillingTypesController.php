<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\BillingTypesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingTypesController extends Controller
{
    private BillingTypesRepositoryInterface $repository;

    private array $columns = [
        'billing_type', 
        'billing_type_description', 
        'billing_perc', 
    ];

    public function __construct(BillingTypesRepositoryInterface $repository)
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
        foreach ($data as $BillingTypeData) {
      
            $this->repository->updateInsert($BillingTypeData, 'billing_type');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}