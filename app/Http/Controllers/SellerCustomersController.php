<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\SellerCustomersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerCustomersController extends Controller
{
    private SellerCustomersRepositoryInterface $repository;

    private array $columns = [
        'seller', 
        'customer'    
    ];

    public function __construct(SellerCustomersRepositoryInterface $repository)
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
        foreach ($data as $SellerCustomerData) {
      
            $this->repository->updateInsertTP($SellerCustomerData, 'seller', 'customer');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}