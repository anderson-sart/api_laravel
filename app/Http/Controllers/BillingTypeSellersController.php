<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\BillingTypeSellersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillingTypeSellersController extends Controller
{
    private BillingTypeSellersRepositoryInterface $repository;

    private array $columns = [
        'billing_type', 
        'seller'
    ];

    public function __construct(BillingTypeSellersRepositoryInterface $repository)
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
        foreach ($data as $BillingTypeSellerData) {
      
            $this->repository->updateInsertTP($BillingTypeSellerData, 'billing_type', 'seller');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}