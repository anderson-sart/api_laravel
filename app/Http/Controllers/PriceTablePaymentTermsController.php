<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\PriceTablePaymentTermsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceTablePaymentTermsController extends Controller
{
    private PriceTablePaymentTermsRepositoryInterface $repository;

    private array $columns = [
        'price_table', 
        'payment_term', 
        'status'
    ];

    public function __construct(PriceTablePaymentTermsRepositoryInterface $repository)
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
        foreach ($data as $PriceTablePaymentTermData) {
      
            $this->repository->updateInsertTP($PriceTablePaymentTermData, 'price_table', 'payment_term');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}