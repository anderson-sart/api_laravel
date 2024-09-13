<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\PaymentTermMediumsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentTermMediumsController extends Controller
{
    private PaymentTermMediumsRepositoryInterface $repository;

    private array $columns = [
        'payment_term_medium', 
        'minimum_discount_percentage',
        'maximum_discount_percentage'
    ];

    public function __construct(PaymentTermMediumsRepositoryInterface $repository)
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
        foreach ($data as $PaymentTermMediumData) {
      
            $this->repository->updateInsert($PaymentTermMediumData, 'payment_term_medium');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}