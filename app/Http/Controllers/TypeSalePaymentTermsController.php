<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\TypeSalePaymentTermsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeSalePaymentTermsController extends Controller
{
    private TypeSalePaymentTermsRepositoryInterface $repository;

    private array $columns = [
        'type_sale', 
        'payment_term'
    ];

    public function __construct(TypeSalePaymentTermsRepositoryInterface $repository)
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
        foreach ($data as $TypeSalePaymentTermData) {
      
            $this->repository->updateInsertTP($TypeSalePaymentTermData, 'type_sale', 'payment_term');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}