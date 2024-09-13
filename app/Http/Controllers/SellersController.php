<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\SellersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellersController extends Controller
{
    private SellersRepositoryInterface $repository;

    protected $columns = [
        'seller', 
        'cpf_cnpj', 
        'corporate_name',
        'nickname',
        'email',
        'phone',
        'city'
    ];

    public function __construct(SellersRepositoryInterface $repository)
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
                'seller' => $item->seller,
                'cpf_cnpj' => $item->cpf_cnpj,
                'corporate_name' => $item->corporate_name,
                'nickname' => $item->nickname,
                'email' => $item->email,
                'phone' => $item->phone,
                'cidade' => $item->city
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
        foreach ($data as $PaymentTermData) {
      
            $this->repository->updateInsert($PaymentTermData, 'seller');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}