<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\CustomersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    private CustomersRepositoryInterface $repository;

    protected $columns = [
        'customer', 
        'cpf_cnpj', 
        'corporate_name',
        'nickname',
        'email',
        'phone',
        'contact',
        'city',
        'expired_financial_title'
    ];

    public function __construct(CustomersRepositoryInterface $repository)
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
                'customer' => $item->customer,
                'cpf_cnpj' => $item->cpf_cnpj,
                'corporate_name' => $item->corporate_name,
                'nickname' => $item->nickname,
                'email' => $item->email,
                'phone' => $item->phone,
                'cidade' => $item->city,
                'expired_financial_title' => $item->expired_financial_title
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
      
            $this->repository->updateInsert($PaymentTermData, 'customer');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}