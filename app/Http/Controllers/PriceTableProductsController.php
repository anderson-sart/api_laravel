<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\PriceTableProductsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceTableProductsController extends Controller
{
    private PriceTableProductsRepositoryInterface $repository;

    protected $columns = [
        'price_table', 
        'product', 
        'price'
    ];

    public function __construct(PriceTableProductsRepositoryInterface $repository)
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
            $this->repository->updateInsertP($RowData, 'price_table','product');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}