<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\TypeSalesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeSalesController extends Controller
{
    private TypeSalesRepositoryInterface $repository;

    private array $columns = [
        'type_sale',
        'type_sale_description'
    ];

    public function __construct(TypeSalesRepositoryInterface $repository)
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
        foreach ($data as $TypeSaleData) {
      
            $this->repository->updateInsert($TypeSaleData, 'type_sale');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}