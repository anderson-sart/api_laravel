<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\PriceTablesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceTablesController extends Controller
{
    private PriceTablesRepositoryInterface $repository;

    private array $columns = [
        'price_table',
        'price_table_code',
        'price_table_description'
    ];

    public function __construct(PriceTablesRepositoryInterface $repository)
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
        foreach ($data as $PriceTableData) {
      
            $this->repository->updateInsert($PriceTableData, 'price_table');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}