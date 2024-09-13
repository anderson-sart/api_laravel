<?php


namespace App\Http\Controllers;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    private UsersRepositoryInterface $repository;

    protected $columns = [
        'name',
        'email',
        'password',
        'edit_perc_discount',
        'edit_perc_discount_item_sale',
        'user_type'
    ];

    public function __construct(UsersRepositoryInterface $repository)
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
                'username' => $item->name,
                'email' => $item->email,
                'password' => $item->password,
                'edit_perc_discount' => $item->edit_perc_discount,
                'edit_perc_discount_item_sale' => $item->edit_perc_discount_item_sale
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
            //$RowData['password'] = Hash::make($RowData['password']);
            $this->repository->updateInsert($RowData, 'name');
            
        }

        return response()->json(['message' => 'table updates successfully'], 201);
    }
}