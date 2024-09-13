<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\PaymentTermBillingTypesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentTermBillingTypesController extends Controller
{
    private PaymentTermBillingTypesRepositoryInterface $repository;

    private array $columns = [
        'payment_term', 
        'billing_type'
    ];

    public function __construct(PaymentTermBillingTypesRepositoryInterface $repository)
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
        foreach ($data as $PaymentTermBillingTypeData) {
      
            $this->repository->updateInsertTP($PaymentTermBillingTypeData, 'billing_type', 'payment_term');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}