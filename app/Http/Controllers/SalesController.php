<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\SalesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\BrandsRepositoryInterface;
use App\Repositories\Interfaces\CustomersRepositoryInterface;
use App\Repositories\Interfaces\SellersRepositoryInterface;
use App\Repositories\Interfaces\PriceTablesRepositoryInterface;
use App\Repositories\Interfaces\TypeSalesRepositoryInterface;
use App\Repositories\Interfaces\CarriersRepositoryInterface;
use App\Repositories\Interfaces\CompaniesRepositoryInterface;
use App\Repositories\Interfaces\PaymentTermsRepositoryInterface;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use App\Repositories\Interfaces\SaleItemsRepositoryInterface;
use App\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Repositories\Interfaces\BillingTypesRepositoryInterface;
use App\Repositories\Interfaces\SaleDeliveryPeriodsRepositoryInterface;
use App\Models\SaleItem;
use App\Utils\DateUtils;
use App\Utils\DiscountHelper;
use App\Filters\SalesFilters;
use Illuminate\Support\Facades\Log; // Importar o Log
use Illuminate\Support\Facades\DB; // Importando o namespace DB
use PDF; // Importar a facade do Dompdf

class SalesController extends Controller
{
    private SalesRepositoryInterface $repository;
    private BrandsRepositoryInterface $brandRepository;
    private CustomersRepositoryInterface $customersRepository;
    private SellersRepositoryInterface $sellersRepository;
    private PriceTablesRepositoryInterface $priceTablesRepository;
    private TypeSalesRepositoryInterface $typeSalesRepository;
    private CarriersRepositoryInterface $carriersRepository;
    private CompaniesRepositoryInterface $companiesRepository;
    private PaymentTermsRepositoryInterface $paymentTermsRepository;
    private UsersRepositoryInterface $usersRepository;
    private SaleItemsRepositoryInterface $saleItemsRepository;
    private ProductsRepositoryInterface $productsRepository;

    private BillingTypesRepositoryInterface $billingtypesrepository;
    private SaleDeliveryPeriodsRepositoryInterface $saleDeliveryPeriodsRepository;

    
    protected $columns = [
        'id',
        'seller_id', 
        'off_seller', 
        'customer_id', 
        'off_customer', 
        'price_table_id', 
        'off_price_table', 
        'type_sale_id', 
        'off_type_sale', 
        'brand_id', 
        'off_brand', 
        'payment_term_id', 
        'off_payment_term', 
        'user_id', 
        'off_user', 
        'carrier_id', 
        'off_carrier', 
        'sale_code',
        'delivery_date', 
        'gross_total_amount', 
        'total_amount', 
        'total_discount_amount', 
        'emission_date', 
        'observation', 
        'perc_desconto_1', 
        'perc_desconto_2',
        'database_id',
        'export_return',
        'customer_cnpj',
        'customer_email',
        'customer_contact',
        'customer_phone',
        'customer_corporate_name',
        'off_billing_type',
        'billing_type_id',
        'sale_code_online',
        'status'
    ];

    public function __construct(
        SalesRepositoryInterface $repository,
        BrandsRepositoryInterface $brandRepository,
        CustomersRepositoryInterface $customersRepository,
        SellersRepositoryInterface $sellersRepository,
        PriceTablesRepositoryInterface $priceTablesRepository,
        TypeSalesRepositoryInterface $typeSalesRepository,
        CarriersRepositoryInterface $carriersRepository,
        CompaniesRepositoryInterface $companiesRepository,
        PaymentTermsRepositoryInterface $paymentTermsRepository,
        UsersRepositoryInterface $usersRepository,
        SaleItemsRepositoryInterface $saleItemsRepository,
        ProductsRepositoryInterface $productsRepository,
        BillingTypesRepositoryInterface $billingtypesrepository,
        SaleDeliveryPeriodsRepositoryInterface $saleDeliveryPeriodsRepository
    )
    {
        $this->repository = $repository;
        $this->brandRepository = $brandRepository;
        $this->customersRepository = $customersRepository;
        $this->sellersRepository = $sellersRepository;
        $this->priceTablesRepository = $priceTablesRepository;
        $this->typeSalesRepository = $typeSalesRepository;
        $this->carriersRepository = $carriersRepository;
        $this->companiesRepository = $companiesRepository;
        $this->paymentTermsRepository = $paymentTermsRepository;
        $this->usersRepository = $usersRepository;
        $this->saleItemsRepository = $saleItemsRepository;
        $this->productsRepository = $productsRepository;
        $this->billingtypesrepository = $billingtypesrepository;
        $this->saleDeliveryPeriodsRepository = $saleDeliveryPeriodsRepository;

    }

    public function index(): JsonResponse
    {
        //listBy statua
        $criteria = array('status' => 'A');
        $relations = array(
            'brand',
            'customer',
            'carrier',
            'seller',
            'user',
            'priceTable',
            'typeSale',
            'paymentTerm',
            'billingType',
            'saleItems',
            'saleItems.product'
            
        );
        
        $itens_array = $this->repository->listBy(
            $criteria, 
            $this->columns,
            orderByClause: 'id',
            orderByType: 'asc',
            relations: $relations,
        );               

        $arrayRetorno = array();       
        $arrayRetorno['code'] = 200;
        $arrayRetorno['data'] = $itens_array;
        return response()->json($arrayRetorno);
    }
    public function ListaVenda(Request $request, int $id): JsonResponse
    {
        //listBy statua
        $criteria = array('id' => $id);
        $relations = array(
            'brand',
            'customer',
            'carrier',
            'seller',
            'user',
            'priceTable',
            'typeSale',
            'paymentTerm',
            'billingType',
            'saleItems',
            'saleItems.product'
            
        );
        
        $itens_array = $this->repository->listBy(
            $criteria, 
            $this->columns,
            orderByClause: 'id',
            orderByType: 'asc',
            relations: $relations,
        );               

        $arrayRetorno = array();       
        $arrayRetorno['code'] = 200;
        $arrayRetorno['data'] = $itens_array;
        return response()->json($arrayRetorno);
    }
    public function store(Request $request)
    {
        Log::info('Store method called');
        // Verificar se a solicitação contém JSON
        if ($request->isJson()) {
            // Tentar decodificar o JSON
            $postData = $request->json()->all();

            // Verificar se o JSON foi decodificado corretamente
            if (json_last_error() === JSON_ERROR_NONE) {

                // Converter o JSON em uma string formatada
                $jsonString = json_encode($postData, JSON_PRETTY_PRINT);

                // Definir o caminho do arquivo
                $filePath = storage_path('app/posts/') . 'post_' . uniqid() . '.json';

                // Salvar o JSON no arquivo
                file_put_contents($filePath, $jsonString);

                $data = $request->all();
                foreach ($data as $RowData) {
                    $this->checkAndProcessDatabaseId($RowData);

                    // Definição do mapeamento de chaves
                    $mapping = [
                        'sale_code'             => 'saleCode',
                        'gross_total_amount'    => 'grossTotalAmount',
                        'total_amount'          => 'totalAmount',
                        'total_discount_amount' => 'totalDiscountAmount',
                        'perc_desconto_1'       => 'percDesconto1',
                        'perc_desconto_2'       => 'percDesconto2',
                        'sale_code_online'  => 'saleCodeOnline'
                    ];

                    // Chamada da função para mapear e renomear chaves
                    $this->mapAndRenameKeys($RowData, $mapping);

                    $this->handleDeliveryDate($RowData, 'deliveryDate');

                    $this->handleEmissionDate($RowData, 'emissionDate');
    
                    if (!array_key_exists('customer', $RowData)) {
                        $RowData['customer_id'] = null;
                        
                        $fields = [
                            'customer_cnpj'     => 'customerCnpj',
                            'customer_email'    => 'customerEmail',
                            'customer_contact'  => 'customerContact',
                            'customer_corporate_name' => 'customerCorporateName',
                            'customer_phone'    => 'customerPhone',
                        ];
                        // Chamada da função para mapear e renomear chaves
                        $this->mapAndRenameKeys($RowData, $fields);
                    }

                    $RowData = $this->processData($RowData, 'brand', 'brand', $this->brandRepository);
                    $RowData = $this->processData($RowData, 'customer', 'customer', $this->customersRepository);
                    $RowData = $this->processData($RowData, 'seller', 'seller', $this->sellersRepository);
                    $RowData = $this->processData($RowData, 'priceTable', 'price_table', $this->priceTablesRepository);
                    $RowData = $this->processData($RowData, 'typeSale', 'type_sale', $this->typeSalesRepository);
                    $RowData = $this->processData($RowData, 'carrier', 'carrier', $this->carriersRepository);
                    $RowData = $this->processData($RowData, 'paymentTerm', 'payment_term', $this->paymentTermsRepository);

                    // Processando billingType e user usando processSpecialData
                    $RowData = $this->processSpecialData($RowData, 'billingType', 'billing_type', $this->billingtypesrepository, 'billing_type');
                    $RowData = $this->processSpecialData($RowData, 'user', 'user', $this->usersRepository, 'name');

                    if (!isset($RowData['database_id']) || empty($RowData['database_id'])) {
                        return response()->json([
                            'status' => 'ERRO',
                            'message' => 'venda sem identificado do coletor',
                            'registro' => $RowData
                            ], 404);
                    }
                    $clauses = array(
                        'sale_code' => $RowData['sale_code'],
                        'database_id' => $RowData['database_id'],
                    );
                    $whereClauses[] = ['status' , '<>' , 'C'];
                    $arrayT = $this->repository->findBy2($clauses, $whereClauses);
                    if ($arrayT && ($arrayT['status'] == 'D' or $arrayT['status'] == 'X')) {
                        $input = array();
                        $input['status'] = 'C';
                        $updated = $this->repository->update($input, $arrayT['id']);
                        $arrayT = null;
                    }

                    if ($arrayT) {
                        return response()->json([
                            'status' => 'ERRO',
                            'message' => 'venda ja inserida na base',
                            'registro' => $arrayT
                            ], 404);
                    }else{
                        $RowData['status'] = 'X';
                        $createdSale = $this->repository->create($RowData);
                        //items no que esta os produtos
                        if (isset($RowData['items']) && is_array($RowData['items']) && !empty($RowData['items'])) {
                            foreach ($RowData['items'] as $RowItem) {
                               
                                $this->handleProduct($RowItem, 'product', 'color', 'size');
                           
                                $RowItem['sale_id'] = $createdSale['id'];
                                $RowItem['status'] = 'A';
                                $RowItem['sale_item_code'] = $RowItem['saleItemCode'];
                                $RowItem['sale_code'] = $createdSale['sale_code'];
                                $RowItem['total_quantity'] = $RowItem['totalQuantity'];
                                $RowItem['unitary_price'] = $RowItem['unitaryPrice'];
                                $RowItem['gross_total_amount_item'] = $RowItem['grossTotalAmountItem'];
                                $RowItem['total_amount_item'] = $RowItem['totalAmountItem'];
                                $RowItem['total_discount_amount_item'] = $RowItem['totalDiscountAmountItem'];
                                $RowItem['discount_percentage'] = $RowItem['discountPercentage'];
                                $RowItem['discount_percentage_type'] = $RowItem['discountPercType'];
                                
                                $this->handleDeliveryDateWithDefault($RowItem, 'dataEntrega');

                                $perc_desconto_1 = $RowData['perc_desconto_1'] ?? 0;
                                $perc_desconto_2 = $RowData['perc_desconto_2'] ?? 0;
                                $preco_liquido = DiscountHelper::calcularValorLiquido($RowItem, $perc_desconto_1 , $perc_desconto_2);

                                $RowItem['net_unitary_price'] = $preco_liquido;
                                $RowItem['total_amount_item'] = $RowItem['total_quantity'] * $preco_liquido;
                                $RowItem['total_amount_item'] =  number_format($RowItem['total_amount_item'], 3, '.', '');
                                $RowItem['total_discount_amount_item'] =  $RowItem['grossTotalAmountItem'] - $RowItem['total_amount_item'];
                                $RowItem['total_discount_amount_item'] =  number_format($RowItem['total_discount_amount_item'], 3, '.', '');
                       
                                $created_item = $this->saleItemsRepository->create($RowItem);
                                
                            }
                            $input = array();
                            $input['status'] = 'A';
                            $updated = $this->repository->update($input, $createdSale['id']);
                            if (isset($RowData['sale_code_online']) && !empty($RowData['sale_code_online'])) {
                                //sale_code_online cancelar venda digitando que veio de outro coletor
                                $clauses = array(
                                    'id' => $RowData['sale_code_online']
                                );
                                $whereClauses[] = ['status' , '<>' , 'C'];
                                $array_old = $this->repository->findBy2($clauses, $whereClauses);
                               
                                if ($array_old && ($array_old['status'] == 'D' or $array_old['status'] == 'X')) {
                                    $input = array();
                                    $input['status'] = 'C';
                                    $updated = $this->repository->update($input, $array_old['id']);
                                }
                            }
                            return response()->json([
                                'status' => 'ok',
                                'message' => 'Venda inserida com sucesso',
                                'registro' => $createdSale
                                ], 201);            
                        }else{
                            $this->repository->deleteId($createdSale['id']);
                            return response()->json([
                                'status' => 'ERRO',
                                'message' => 'venda sem items',
                                'registro' => $createdSale
                                ], 404);
                        }
                    } 
                    
                }
            } else {
                // O JSON é inválido
                return response()->json([
                    'status' => 'ERRO',
                    'message' => 'JSON inválido' ], 404);
            }
        } else {
            // A solicitação não contém JSON
            return response()->json([
                'status' => 'ERRO',
                'message' => 'Requisição inválida: não é JSON' ], 404);
        }

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Access Request Data
        $input = $this->getRequestData($request);

        $clauses = array('id' => $id);
        $arrayT = $this->repository->findBy($clauses);

        if (is_null($arrayT)) {
            return response()->json('Venda não encontrada / Sem acesso ao recurso', 404);
        }

        $updated = $this->repository->update($input, $id);

        if (is_null($updated)) {
            return response()->json('Venda não encontrada / Sem acesso ao recurso', 404);
        }

        return response()->json($id, 202);
    }

    public function groupItemsByDeliveryPeriod(Request $request, $id)
    {
        // Verifica se a venda existe
        $clauses = array('id' => $id);
        $sale = $this->repository->findBy($clauses);
        
        // Obtém os períodos de entrega
   
        $periods = $this->saleDeliveryPeriodsRepository->listBy(array());


        
        $groupedItems = [];

        // Itera sobre cada período e agrupa os itens
        foreach ($periods as $period) {
            
            $items = SaleItem::where('sale_id', $id)
                ->whereBetween('delivery_date', [$period->initial_date, $period->final_date])
                ->get();

            // $whereClauses[] = ['status' , '<>' , 'C'];    
            // $clauses = array('id' => $id);
            // $items = $this->saleItemsRepository->findBy($clauses); 
            if ( is_array($items) && !empty($items)) {

            }
            $groupedItems[] = [
                'period' => $period,
                'items' => $items,
            ];
        }

        return response()->json($groupedItems);
    }

    public function listaQuebra(Request $request, $id)
    {
        // Construindo a consulta com o Eloquent
        $deliveryPeriods = $this->saleItemsRepository->saleItemQ($id );
        //return response()->json($deliveryPeriods);

        // Iterar sobre cada período de entrega
        foreach ($deliveryPeriods as $period) {
            // Buscar os itens que estão dentro do intervalo de datas

            $items = $this->saleItemsRepository->listPeriod($id, $period->initial_date, $period->final_date );

            $results[] = [
                'period' => $period,
                'items' => $items
            ];
           
        }

        return response()->json($results);
    }

    public function printPDF($id)
    {
        $clauses = array('id' => $id);
        $relations = array(
            'brand',
            'customer',
            'carrier',
            'seller',
            'user',
            'priceTable',
            'typeSale',
            'paymentTerm',
            'billingType'
        );
        $sale = $this->repository->findBy($clauses,$this->columns,$relations);
 
        $deliveryPeriods = $this->saleItemsRepository->saleItemQ($id );

        // Inicializar o array de resultados
        $item_group = [];
        // Verificar se deliveryPeriods não está vazio
        if (!$deliveryPeriods->isEmpty()) {
            // Iterar sobre cada período de entrega
            foreach ($deliveryPeriods as $period) {
                // Buscar os itens que estão dentro do intervalo de datas

                $items = $this->saleItemsRepository->listPeriod($id, $period->initial_date, $period->final_date );
                $item_array = [];
                foreach ($items as $item) {
                    $item->perc_desconto_1 = $sale->perc_desconto_1;
                    $item->perc_desconto_2 = $sale->perc_desconto_2;
                    $item->preco_liquido = DiscountHelper::calcularValorLiquido($item, $sale->perc_desconto_1, $sale->perc_desconto_2);
                    $item_array[] = $item;
             

                }
                $item_group[] = [
                    'period' => $period,
                    'items' => $item_array ?: []
                ];
            
            }
        }
        
        $company = $this->companiesRepository->findBy([]);
        //return response()->json($company);

        // Configuração e geração do PDF
        $filename = 'venda_' . $sale->sale_code . '.pdf';

        //return view('sales.print-pdf', compact('sale', 'item_group'));
        // Carregar a view e passar os dados
        $pdf = PDF::loadView('sales.print-pdf', compact('sale','item_group', 'company'));

        // Definir o papel e as margens
        $pdf->setPaper('A4', 'portrait');

        // Adicionar rodapé
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $canvas->page_text(520, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0,0,0));

        // Retornar o PDF para download
        // return $pdf->download($filename);

        // Retornar o PDF para visualização no navegador
        return $pdf->stream($filename);
    }

    private function getRequestData(Request $request): array
    {
        $data = $request->only([
            'id',
            'seller_id', 
            'database_id',
            'export_return',
            'status'
        ]);
        
        return $data;
    }
    
    public function listaDigitando(Request $request, SalesFilters $filters): JsonResponse
    {
        //listBy statua
        
        $relations = array(
            'brand',
            'customer',
            'carrier',
            'seller',
            'user',
            'priceTable',
            'typeSale',
            'paymentTerm',
            'billingType',
            'saleItems',
            'saleItems.product'
        );     
        $status = array('D');          
        $itens_array = $this->repository->listByDias(
            $filters,
            null, 
            $this->columns,
            orderByClause: 'id',
            orderByType: 'asc',
            relations: $relations,
            diasFiltro: 15,
            statusIN: $status 
        );    
         
        $arrayRetorno = array();       
        $arrayRetorno['code'] = 200;
        $arrayRetorno['data'] = $itens_array;
        return response()->json($arrayRetorno);
    }

    public function list(Request $request, SalesFilters $filters)
    {
        $relations = array(
            'brand',
            'customer',
            'carrier',
            'seller',
            'user',
            'priceTable',
            'typeSale',
            'paymentTerm',
            'saleItems',
            
        );
        $perPage = $request->input('per_page', 50);
        $criteria = array();
        $sales = $this->repository->filterWithPagination(
            $filters, 
            ['*'],
            $perPage,
            relations: $relations,
            orderByClause: 'created_at',
            orderByType: 'desc',
            criteria: $criteria
        );
        // return response()->json($sales);
        $statusMapping = [
            'A' => 'Finalizada',
            'I' => 'Exportada',
            'C' => 'Cancelada',
            'D' => 'Digitando',
            'X' => 'Inserindo',
        ];
        $colorMapping = [
            'X' => '#ffa50052', // Laranja
            'C' => '#ff00005c', // Vermelho
            'D' => '#80008052',  // Roxo
            'A' => '#00800073', // Verde
            'I' => '#0000ff78', // Azul 
        ];
        // Recalcular o preço líquido para cada item
        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $item) {
                // Substitua com os valores reais de desconto, se necessário
                $item->preco_liquido = DiscountHelper::calcularValorLiquido($item, $sale->perc_desconto_1, $sale->perc_desconto_2);
                $item->net_unitary_price            = $item->preco_liquido;
                $item->total_amount_item            = $item->preco_liquido * $item->total_quantity;
                $item->total_amount_item            = round($item->total_amount_item  , 2);
                $item->total_discount_amount_item   = ($item->unitary_price * $item->total_quantity) - ($item->preco_liquido * $item->total_quantity);
                $item->total_discount_amount_item   = round($item->total_discount_amount_item  , 2);

                $item->net_unitary_price            = number_format($item->net_unitary_price, 2, '.', '');
                $item->total_amount_item            = number_format($item->total_amount_item, 2, '.', '');
                $item->total_discount_amount_item   = number_format($item->total_discount_amount_item, 2, '.', '');
            }
        }
        $users  = $this->usersRepository->all();
        return view('sales.index', compact('sales', 'statusMapping','users', 'colorMapping'));
    }
    

    public function typingStore(Request $request)
    {
        Log::info('TypingStore method called');
        // Verificar se a solicitação contém JSON
        if ($request->isJson()) {
            // Tentar decodificar o JSON
            $postData = $request->json()->all();

            // Verificar se o JSON foi decodificado corretamente
            if (json_last_error() === JSON_ERROR_NONE) {

                // Converter o JSON em uma string formatada
                $jsonString = json_encode($postData, JSON_PRETTY_PRINT);

                // Definir o caminho do arquivo
                $filePath = storage_path('app/posts/') . 'post_digitando' . uniqid() . '.json';

                // Salvar o JSON no arquivo
                file_put_contents($filePath, $jsonString);

                $data = $request->all();
                foreach ($data as $RowData) {
                    $this->checkAndProcessDatabaseId($RowData);
        
                    // Definição do mapeamento de chaves
                    $mapping = [
                        'sale_code'             => 'saleCode',
                        'gross_total_amount'    => 'grossTotalAmount',
                        'total_amount'          => 'totalAmount',
                        'total_discount_amount' => 'totalDiscountAmount',
                        'perc_desconto_1'       => 'percDesconto1',
                        'perc_desconto_2'       => 'percDesconto2',
                        'sale_code_online'  => 'saleCodeOnline'
                    ];

                    // Chamada da função para mapear e renomear chaves
                    $this->mapAndRenameKeys($RowData, $mapping);

                    $this->handleDeliveryDate($RowData, 'deliveryDate');

                    $this->handleEmissionDate($RowData, 'emissionDate');

                    if (!array_key_exists('customer', $RowData)) {
                        $RowData['customer_id'] = null;
                        $fields = [
                            'customer_cnpj'     => 'customerCnpj',
                            'customer_email'    => 'customerEmail',
                            'customer_contact'  => 'customerContact',
                            'customer_corporate_name' => 'customerCorporateName',
                            'customer_phone'    => 'customerPhone',
                        ];
                        // Chamada da função para mapear e renomear chaves
                        $this->mapAndRenameKeys($RowData, $fields);
                    }

                    $RowData = $this->processData($RowData, 'brand', 'brand', $this->brandRepository);
                    $RowData = $this->processData($RowData, 'customer', 'customer', $this->customersRepository);
                    $RowData = $this->processData($RowData, 'seller', 'seller', $this->sellersRepository);
                    $RowData = $this->processData($RowData, 'priceTable', 'price_table', $this->priceTablesRepository);
                    $RowData = $this->processData($RowData, 'typeSale', 'type_sale', $this->typeSalesRepository);
                    $RowData = $this->processData($RowData, 'carrier', 'carrier', $this->carriersRepository);
                    $RowData = $this->processData($RowData, 'paymentTerm', 'payment_term', $this->paymentTermsRepository);

                    // Processando billingType e user usando processSpecialData
                    $RowData = $this->processSpecialData($RowData, 'billingType', 'billing_type', $this->billingtypesrepository, 'billing_type');
                    $RowData = $this->processSpecialData($RowData, 'user', 'user', $this->usersRepository, 'name');
                    if (!isset($RowData['database_id']) || empty($RowData['database_id'])) {
                        return response()->json([
                            'status' => 'ERRO',
                            'message' => 'venda sem identificado do coletor',
                            'registro' => $RowData
                            ], 404);
                    }
                    $clauses = array(
                        'sale_code' => $RowData['sale_code'],
                        'database_id' => $RowData['database_id'],
                    );
                    $whereClauses[] = ['status' , '<>' , 'C'];
                    $arrayT = $this->repository->findBy2($clauses, $whereClauses);
                    if ($arrayT && ($arrayT['status'] == 'D' or $arrayT['status'] == 'X')) {
                        $input = array();
                        $input['status'] = 'C';
                        $updated = $this->repository->update($input, $arrayT['id']);
                        $arrayT = null;
                    }
                    if ($arrayT) {
                        return response()->json([
                            'status' => 'ERRO',
                            'message' => 'venda ja inserida na base como Finalizada',
                            'registro' => $arrayT
                            ], 404);
                    }else{
                        $RowData['status'] = 'X';
                        
                        $createdSale = $this->repository->create($RowData);
                        //items no que esta os produtos
                        if (isset($RowData['items']) && is_array($RowData['items']) && !empty($RowData['items'])) {
                            foreach ($RowData['items'] as $RowItem) {
                               
                                $this->handleProduct($RowItem, 'product', 'color', 'size');
                  
                                $RowItem['sale_id'] = $createdSale['id'];
                                $RowItem['status'] = 'A';
                                $RowItem['sale_item_code'] = $RowItem['saleItemCode'];
                                $RowItem['sale_code'] = $createdSale['sale_code'];
                                $RowItem['total_quantity'] = $RowItem['totalQuantity'];
                                $RowItem['unitary_price'] = $RowItem['unitaryPrice'];
                                $RowItem['gross_total_amount_item'] = $RowItem['grossTotalAmountItem'];
                                $RowItem['total_amount_item'] = $RowItem['totalAmountItem'];
                                $RowItem['total_discount_amount_item'] = $RowItem['totalDiscountAmountItem'];
                                $RowItem['discount_percentage'] = $RowItem['discountPercentage'];
                                $RowItem['discount_percentage_type'] = $RowItem['discountPercType'];
                                
                                $this->handleDeliveryDateWithDefault($RowItem, 'dataEntrega');
                                $perc_desconto_1 = $RowData['perc_desconto_1'] ?? 0;
                                $perc_desconto_2 = $RowData['perc_desconto_2'] ?? 0;
                                $preco_liquido = DiscountHelper::calcularValorLiquido($RowItem, $perc_desconto_1 , $perc_desconto_2);

                                $RowItem['net_unitary_price'] = $preco_liquido;
                                $RowItem['total_amount_item'] = $RowItem['total_quantity'] * $preco_liquido;
                                $RowItem['total_amount_item'] =  number_format($RowItem['total_amount_item'], 3, '.', '');
                                $RowItem['total_discount_amount_item'] =  $RowItem['grossTotalAmountItem'] - $RowItem['total_amount_item'];
                                $RowItem['total_discount_amount_item'] =  number_format($RowItem['total_discount_amount_item'], 3, '.', '');

                                $created_item = $this->saleItemsRepository->create($RowItem);
                                
                            }
                                    
                        }

                        $input = array();
                        $input['status'] = 'D';
                        $updated = $this->repository->update($input, $createdSale['id']);
                        if (isset($RowData['sale_code_online']) && !empty($RowData['sale_code_online'])) {
                            //sale_code_online cancelar venda digitando que veio de outro coletor
                            $clauses = array(
                                'id' => $RowData['sale_code_online']
                            );
                            $whereClauses[] = ['status' , '<>' , 'C'];
                            $array_old = $this->repository->findBy2($clauses, $whereClauses);
                           
                            if ($array_old && ($array_old['status'] == 'D' or $array_old['status'] == 'X')) {
                                $input = array();
                                $input['status'] = 'C';
                                $updated = $this->repository->update($input, $array_old['id']);
                            }
                        }
                        return response()->json([
                            'status' => 'ok',
                            'message' => 'Venda inserida com sucesso',
                            'registro' => $createdSale
                            ], 201);    
                    } 
                    
                }
            } else {
                // O JSON é inválido
                return response()->json([
                    'status' => 'ERRO',
                    'message' => 'JSON inválido' ], 404);
            }
        } else {
            // A solicitação não contém JSON
            return response()->json([
                'status' => 'ERRO',
                'message' => 'Requisição inválida: não é JSON' ], 404);
        }

        
    }

    public function listFinalizado(Request $request, SalesFilters $filters): JsonResponse
    {
        //listBy statua
        
        $relations = array(
            'brand',
            'customer',
            'carrier',
            'seller',
            'user',
            'priceTable',
            'typeSale',
            'paymentTerm',
            'billingType',
            'saleItems',
            'saleItems.product'
            
        );     
        $status = array('A','I');          
        $itens_array = $this->repository->listByDias(
            $filters,
            null, 
            $this->columns,
            orderByClause: 'id',
            orderByType: 'asc',
            relations: $relations,
            diasFiltro: 15,
            statusIN: $status 
        );    
         
        $arrayRetorno = array();       
        $arrayRetorno['code'] = 200;
        $arrayRetorno['data'] = $itens_array;
        return response()->json($arrayRetorno);
    }

    /**
     * Manipula o campo de emissão de data, convertendo-o para Carbon e definindo para a data atual se estiver vazio.
     * @param array &$RowData Referência ao array de dados da linha
     * @param string $field Nome do campo de data de emissão original
     * @return void
     */
    private function handleEmissionDate(array &$RowData, string $field): void
    {
        if (array_key_exists($field, $RowData) && !empty($RowData[$field])) {
            $RowData['emission_date'] = str_replace('-', '/', $RowData[$field]);
            $timestamp = strtotime(str_replace('/', '-', $RowData['emission_date']));
            if ($timestamp !== false && $timestamp !== -1) {
                $RowData['emission_date'] = DateUtils::convertStringToCarbonDate($RowData['emission_date'])->toDateString();
            } else {
                // A data não é válida
                $RowData['emission_date'] = DateUtils::getCurrentDate();
            }
        } else {
            // Se o campo não existir ou estiver vazio, usa a data atual
            $RowData['emission_date'] = DateUtils::getCurrentDate();
        }
        unset($RowData[$field]);
    }

    private function processData($RowData, $key, $column, $repository)
    {
        if (array_key_exists($key, $RowData)) {
            $value = $RowData[$key][$key];
            $RowData['off_' . $column] = $value;
            $clauses = array($column => $value);
            $arrayT = $repository->findBy($clauses);
            $RowData[$column . '_id'] = $arrayT ? $arrayT['id'] : null;
        } else {
            $RowData[$column . '_id'] = null;
        }
        unset($RowData[$key]);

        return $RowData;
    }

    private function processSpecialData($RowData, $key, $column, $repository, $searchColumn = null)
    {
        if (array_key_exists($key, $RowData)) {
            $RowData['off_' . $column] = $RowData[$key];
            unset($RowData[$key]);
            if ($RowData['off_' . $column]) {
                $clauses = array($searchColumn ?? $column => $RowData['off_' . $column]);
                $arrayT = $repository->findBy($clauses);
                $RowData[$column . '_id'] = $arrayT ? $arrayT['id'] : null;
            } else {
                $RowData[$column . '_id'] = null;
            }
        } else {
            $RowData[$column . '_id'] = null;
        }

        return $RowData;
    }

    /**
     * Manipula o campo de data de entrega, convertendo-o para Carbon se válido, senão retorna null.
     * @param array &$RowData Referência ao array de dados da linha
     * @param string $field Nome do campo original de data de entrega
     * @return void
     */
    private function handleDeliveryDate(array &$RowData, string $field): void
    {
        $deliveryDate = null;

        if (array_key_exists($field, $RowData) && !empty($RowData[$field])) {
            $deliveryDate = str_replace('-', '/', $RowData[$field]);
            
            $timestamp = strtotime(str_replace('/', '-', $deliveryDate)); // Substituir '/' por '-' para o strtotime() funcionar corretamente
            if ($timestamp !== false && $timestamp !== -1) {
                $deliveryDate = DateUtils::convertStringToCarbonDate($deliveryDate)->toDateString();
            } else {
                // A data não é válida
                $deliveryDate = null; // Define como null se a data não for válida
            }
        }

        $RowData['delivery_date'] = $deliveryDate;
        unset($RowData[$field]);
    }

    /**
     * Manipula o campo de data de entrega, convertendo-o para Carbon se válido, senão retorna a data atual.
     * @param array &$RowItem Referência ao array de dados da linha
     * @param string $field Nome do campo original de data de entrega
     * @return void
     */
    private function handleDeliveryDateWithDefault(array &$RowItem, string $field): void
    {
        if (!isset($RowItem[$field]) || empty($RowItem[$field])) {
            // Se o campo não existir ou estiver vazio, define como a data atual
            $RowItem['delivery_date'] = DateUtils::getCurrentDate();
        } else {
            // Se o campo existir e não estiver vazio, tenta converter para Carbon
            $deliveryDate = str_replace('-', '/', $RowItem[$field]);
            $timestamp = strtotime(str_replace('/', '-', $deliveryDate)); // Substituir '/' por '-' para o strtotime() funcionar corretamente
            
            if ($timestamp !== false && $timestamp !== -1) {
                $RowItem['delivery_date'] = DateUtils::convertStringToCarbonDate3($deliveryDate)->toDateString();
            } else {
                // A data não é válida, define como a data atual
                $RowItem['delivery_date'] = DateUtils::getCurrentDate();
            }
        }

        unset($RowItem[$field]);
    }

    /**
     * Manipula os dados do produto dentro do array $RowItem, definindo o ID do produto se encontrado, senão null.
     * @param array &$RowItem Referência ao array de dados do item
     * @param string $productField Nome do campo original do produto
     * @param string $colorField Nome do campo original da cor
     * @param string $sizeField Nome do campo original do tamanho
     * @return void
     */
    private function handleProduct(array &$RowItem, string $productField, string $colorField, string $sizeField): void
    {
        if (!is_null($RowItem[$productField])) {
            $product = $RowItem[$productField]['product'];   
            $RowItem['off_product'] = $product;
            $color = $RowItem[$productField]['color'];   
            $RowItem['off_color'] = $color;
            $size = $RowItem[$productField]['size'];   
            $RowItem['off_size'] = $size;

            $clauses = array(
                'product' => $product,
                'color' => $color,
                'size' => $size
            );
            $arrayT = $this->productsRepository->findBy($clauses);
            if ($arrayT) {
                $RowItem['product_id'] = $arrayT['id'];
            } else {
                $RowItem['product_id'] = null;
            }  
        } else {
            $RowItem['product_id'] = null;
        }
        
        unset($RowItem[$productField]);
    }

    private function checkAndProcessDatabaseId(&$RowData) {
        $databaseId = isset($RowData['databaseId']) ? $RowData['databaseId'] : null;

        if (is_null($databaseId)) {
            return response()->json([
                'status' => 'ERRO',
                'message' => 'Venda sem o registro do coletor',
                'registro' => $RowData
            ], 201);
        }

        $RowData['database_id'] = $databaseId;
        unset($RowData['databaseId']);
    }

    private function mapAndRenameKeys(array &$RowData, $mapping) {
        foreach ($mapping as $newKey => $oldKey) {
            if (isset($RowData[$oldKey])) {
                $RowData[$newKey] = $RowData[$oldKey];
                unset($RowData[$oldKey]);
            }else{
                $RowData[$newKey] = null;
            }
        }
    }
}