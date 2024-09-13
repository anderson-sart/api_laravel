<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\StocksRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Utils\DateUtils;

class StocksController extends Controller
{
    private StocksRepositoryInterface $repository;

    protected $columns = [
        'product',
        'color', 
        'size', 
        'reserved_amount', 
        'original_amount', 
        'stock_base_date'
    ];

    public function __construct(StocksRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): JsonResponse
    {
        //listBy statua
        $criteria = array('status' => 'A');
        $itensData = $this->repository->listBy($criteria, $this->columns);

        $rowsData = $itensData->map(function ($item) {
            //$date = DateUtils::formatDateString($item->stock_base_date, 'd/m/Y');

            return [
                'product' => $item->product,
                'color' => $item->color,
                'size' => $item->size,
                'reserved_amount' => $item->reserved_amount,
                'original_amount' => $item->original_amount,
                'data_base_saldo_estoque' => $item->stock_base_date
            ];
        });  
        $arrayRetorno = array();       
        $arrayRetorno['code'] = 200;
        $arrayRetorno['data'] = $rowsData;
        return response()->json($arrayRetorno);  
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $this->repository->inactivateAllAll();
        foreach ($data as $RowData) {
            if (!empty($RowData['stock_base_date'])) {
                $RowData['stock_base_date'] = DateUtils::convertStringToCarbonDate2($RowData['stock_base_date'])->toDateString();
            }
            $this->repository->updateInsertP($RowData, 'product','color','size','stock_base_date');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}