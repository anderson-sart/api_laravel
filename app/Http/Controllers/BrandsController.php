<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\BrandsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    private BrandsRepositoryInterface $repository;

    protected $columns = [
        'brand',
        'brand_description'
    ];

    public function __construct(BrandsRepositoryInterface $repository)
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
        foreach ($data as $RowData) {
            $currentDateFormatted = date('Y-m-d H:i:s');
            $RowData['uploadDate'] = $currentDateFormatted;
            $this->repository->updateInsert($RowData, 'brand');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}