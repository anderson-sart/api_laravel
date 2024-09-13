<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\PriceTableBillingTypesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceTableBillingTypesController extends Controller
{
    private PriceTableBillingTypesRepositoryInterface $repository;

    private array $columns = [
        'price_table', 
        'billing_type'
    ];

    public function __construct(PriceTableBillingTypesRepositoryInterface $repository)
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
        foreach ($data as $PriceTableBillingTypeData) {
      
            $this->repository->updateInsertTP($PriceTableBillingTypeData, 'price_table', 'billing_type');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}