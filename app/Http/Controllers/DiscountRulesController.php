<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\DiscountRulesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscountRulesController extends Controller
{
    private DiscountRulesRepositoryInterface $repository;

    protected $columns = [
        'discount_rule',
        'discount_rule_description', 
        'minimum_discount_percentage', 
        'maximum_discount_percentage',  
        'range_sale_value',  
        'range_sale_quantity',  
        'price_table', 
        'type_sale'
    ];

    public function __construct(DiscountRulesRepositoryInterface $repository)
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
            $this->repository->updateInsertP($RowData, 'discount_rule','type_sale','price_table');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}