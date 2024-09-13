<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\PaymentTermsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentTermsController extends Controller
{
    private PaymentTermsRepositoryInterface $repository;

    private array $columns = [
        'payment_term',
        'payment_term_description', 
        'payment_term_medium'
    ];

    public function __construct(PaymentTermsRepositoryInterface $repository)
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
        foreach ($data as $PaymentTermData) {
      
            $this->repository->updateInsert($PaymentTermData, 'payment_term');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}