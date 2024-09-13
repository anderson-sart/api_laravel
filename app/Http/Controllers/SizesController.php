<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\SizesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SizesController extends Controller
{
    private SizesRepositoryInterface $repository;

    protected $columns = [
        'size', 
        'size_description'
    ];

    public function __construct(SizesRepositoryInterface $repository)
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
      
            $this->repository->updateInsert($PaymentTermData, 'size');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}