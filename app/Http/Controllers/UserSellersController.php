<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\UserSellersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserSellersController extends Controller
{
    private UserSellersRepositoryInterface $repository;

    private array $columns = [
        'seller', 
        'user'    
    ];

    public function __construct(UserSellersRepositoryInterface $repository)
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
        foreach ($data as $UserSellerData) {
      
            $this->repository->updateInsertTP($UserSellerData, 'seller', 'user');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}