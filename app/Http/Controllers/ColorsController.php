<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\ColorsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ColorsController extends Controller
{
    private ColorsRepositoryInterface $repository;

    protected $columns = [
        'color', 
        'color_description'
    ];

    public function __construct(ColorsRepositoryInterface $repository)
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
      
            $this->repository->updateInsert($PaymentTermData, 'color');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}