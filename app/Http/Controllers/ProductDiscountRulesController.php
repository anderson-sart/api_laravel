<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\ProductDiscountRulesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductDiscountRulesController extends Controller
{
    private ProductDiscountRulesRepositoryInterface $repository;

    protected $columns = [
        'product',
        'color', 
        'price_table', 
        'discount_perc_type', 
        'minimum_discount_percentage', 
        'maximum_discount_percentage',  
        'range_sale_value',  
        'range_sale_quantity',
        'product_discount_rule'
    ];

    public function __construct(ProductDiscountRulesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(): JsonResponse
    {
        //listBy statua
        $criteria = array('status' => 'A');
        $itensData = $this->repository->listBy($criteria, $this->columns);
        $rowsData = $itensData->map(function ($item) {
            return [
                'product' => $item->product,
                'color' => $item->color,
                'price_table' => $item->price_table,
                'discount_perc_type' => $item->discount_perc_type,
                'minimum_discount_percentage' => $item->minimum_discount_percentage,
                'maximum_discount_percentage' => $item->maximum_discount_percentage,
                'range_sale_value' => $item->range_sale_value,
                'range_sale_quantity' => $item->range_sale_quantity
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
            $currentDateFormatted = date('Y-m-d H:i:s');
            $RowData['uploadDate'] = $currentDateFormatted;

            $this->repository->updateInsertP($RowData, 'product_discount_rule','price_table');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}