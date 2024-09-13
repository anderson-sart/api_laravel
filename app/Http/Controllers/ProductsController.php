<?php


namespace App\Http\Controllers;

use App\Models\Brand;
use App\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Repositories\Interfaces\BrandsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Utils\DateUtils;

class ProductsController extends Controller
{
    private ProductsRepositoryInterface $repository;
    private BrandsRepositoryInterface $brandRepository;

    protected $columns = [
        'product',
        'product_description',
        'product_code',
        'color', 
        'size', 
        'list_multiples', 
        'bar_code', 
        'type_sale',
        'brand_id'
    ];

    public function __construct(
        ProductsRepositoryInterface $repository,
        BrandsRepositoryInterface $brandRepository
    ) {
        $this->repository = $repository;
        $this->brandRepository = $brandRepository;
    }

    public function index(): JsonResponse
    {
        //listBy statua
        $criteria = array('status' => 'A');
        $relations = array('brand');
        $products = $this->repository->listBy(
                            $criteria, 
                            $this->columns,
                            orderByClause: 'id',
                            orderByType: 'asc',
                            relations: $relations,
                        );
        $productsData = $products->map(function ($product) {
            $brandn = optional($product->brand)->brand; // Obtém a descrição da marca se estiver presente, senão retorna null
            return [
                'product' => $product->product,
                'product_description' => $product->product_description,
                'product_code' => $product->product_code,
                'color' => $product->color,
                'size' => $product->size,
                'list_multiples' => $product->list_multiples,
                'bar_code' => $product->bar_code,
                'brand' => $brandn,
                'type_sale' => $product->type_sale,
            ];
        });  
        $arrayRetorno = array();       
        $arrayRetorno['code'] = 200;
        $arrayRetorno['data'] = $productsData;
        return response()->json($arrayRetorno);

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $this->repository->inactivateAllAll();
        foreach ($data as $RowData) {
            if(!is_null($RowData['brand'])){
                $clauses = array('brand' => $RowData['brand']);
                $arrayT = $this->brandRepository->findBy($clauses);
                if ($arrayT) {
                    $RowData['brand_id'] = $arrayT['id'];
                }else{
                    $RowData['brand_id'] = null;
                }  
            }else{
                $RowData['brand_id'] = null;
            }

            $this->repository->updateInsertP($RowData,'product','color','size', 'type_sale');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}