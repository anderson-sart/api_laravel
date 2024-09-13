<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\AssetsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    private AssetsRepositoryInterface $repository;

    protected $columns = [
        'asset',
        'md5', 
        'filename', 
        'size', 
        'uploadDate', 
        'product',  
        'color',
        'link_filename'
    ];

    public function __construct(AssetsRepositoryInterface $repository)
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
            $this->repository->updateInsert($RowData, 'asset');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}