<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\CompaniesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    private CompaniesRepositoryInterface $repository;

    private array $columns = [
        'id', 
        'company', 
        'cpf_cnpj', 
        'company_name',
        'nickname',
        'email',
        'phone',
        'city',
        'event_description',
        'status' 
    ];

    public function __construct(CompaniesRepositoryInterface $repository)
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
        foreach ($data as $CompaniesData) {
      
            $this->repository->updateInsert($CompaniesData, 'company');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}