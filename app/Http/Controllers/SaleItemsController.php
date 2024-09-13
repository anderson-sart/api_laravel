<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\SaleItemsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleItemsController extends Controller
{
    private SaleItemsRepositoryInterface $repository;

    private array $columns = [
        'sale_id',
        'sale_item_code', 
        'sale_code', 
        'product_id', 
        'off_product', 
        'off_color', 
        'off_size', 
        'sequence', 
        'multiple', 
        'quantity', 
        'total_quantity', 
        'total_perc_discount', 
        'unitary_price', 
        'net_unitary_price',
        'gross_total_amount_item', 
        'total_amount_item', 
        'total_discount_amount_item', 
        'discount_percentage',
        'delivery_date',
        'discount_percentage_type',
    ];

    public function __construct(SaleItemsRepositoryInterface $repository)
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
        foreach ($data as $SaleItemData) {
      
            //$this->repository->updateInsert($SaleItemData, 'sale_item');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}