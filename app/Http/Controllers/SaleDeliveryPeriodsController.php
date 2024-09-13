<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\SaleDeliveryPeriodsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Utils\DateUtils;

class SaleDeliveryPeriodsController extends Controller
{
    private SaleDeliveryPeriodsRepositoryInterface $repository;

    private array $columns = [
        'sale_delivery_period', 
        'description_period' ,
        'initial_date', 
        'final_date' ,
        'date_change' ,
        'data_reference' 
    ];

    public function __construct(SaleDeliveryPeriodsRepositoryInterface $repository)
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
            $RowData['initial_date'] = DateUtils::convertStringToCarbonDate2($RowData['initial_date'])->toDateString();
            $RowData['final_date'] = DateUtils::convertStringToCarbonDate2($RowData['final_date'])->toDateString();
            $RowData['date_change'] = DateUtils::convertStringToCarbonDate2($RowData['date_change'])->toDateString();
            $RowData['data_reference'] = DateUtils::convertStringToCarbonDate2($RowData['data_reference'])->toDateString();
            $this->repository->updateInsert($RowData, 'sale_delivery_period');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}