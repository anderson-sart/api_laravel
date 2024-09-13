<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\SizesController;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SellersController;
use App\Http\Controllers\TypeSalePaymentTermsController;
use App\Http\Controllers\PriceTablePaymentTermsController;
use App\Http\Controllers\PaymentTermsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\SaleDeliveryPeriodsController;
use App\Http\Controllers\PaymentTermMediumsController;
use App\Http\Controllers\TypeSalesController;
use App\Http\Controllers\PriceTablesController;
use App\Http\Controllers\CarriersController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\DiscountRulesController;
use App\Http\Controllers\PriceTableProductsController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductDiscountRulesController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SaleItemsController;
use App\Http\Controllers\BillingTypesController;
use App\Http\Controllers\BillingTypeSellersController;
use App\Http\Controllers\TypeSaleBillingTypesController;
use App\Http\Controllers\SellerCustomersController;
use App\Http\Controllers\PriceTableBillingTypesController;
use App\Http\Controllers\CustomerBillingTypesController;
use App\Http\Controllers\PaymentTermBillingTypesController;
use App\Http\Controllers\UserSellersController;
use App\Http\Controllers\Auth\LoginController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'loginApi']);
// {    "name": "user",
//     "password":"senha"
// }
Route::middleware(['api.headers', 'auth:api'])->group(function () {
    Route::get('customers2', [CustomersController::class, 'index']);
    Route::post('customers2', [CustomersController::class, 'store']);
    Route::get('sizes2', [SizesController::class, 'index']);
    Route::post('sizes2', [SizesController::class, 'store']);
    // Outras rotas protegidas que requerem ambos os middlewares

    // Adicionar o Token no Cabeçalho:
    // Vá para a aba "Headers" no Postman.
    // Adicione um novo cabeçalho:
    // Key: Authorization
    // Value: Bearer seu-token-aqui
});

//Route::middleware(['api.headers', ''auth.api'])->group(function () {
// Por exemplo, você pode adicionar um header Authorization com o valor Bearer <seu_token> se estiver usando autenticação JWT
Route::middleware('api.headers')->group(function () {
    // Definição das rotas da API aqui
    Route::get('customers', [CustomersController::class, 'index']);
    Route::post('customers', [CustomersController::class, 'store']);
    Route::get('payment_terms', [PaymentTermsController::class, 'index']);
    Route::post('payment_terms', [PaymentTermsController::class, 'store']);
    Route::get('price_tables', [PriceTablesController::class, 'index']);
    Route::post('price_tables', [PriceTablesController::class, 'store']);
    Route::get('sellers', [SellersController::class, 'index']);
    Route::post('sellers', [SellersController::class, 'store']);
    Route::get('carriers', [CarriersController::class, 'index']);
    Route::post('carriers', [CarriersController::class, 'store']);
    Route::get('type_sales', [TypeSalesController::class, 'index']);
    Route::post('type_sales', [TypeSalesController::class, 'store']);
    Route::get('colors', [ColorsController::class, 'index']);
    Route::post('colors', [ColorsController::class, 'store']);
    Route::get('sizes', [SizesController::class, 'index']);
    Route::post('sizes', [SizesController::class, 'store']);
    Route::get('assets', [AssetsController::class, 'index']);
    Route::post('assets', [AssetsController::class, 'store']);
    Route::get('brands', [BrandsController::class, 'index']);
    Route::post('brands', [BrandsController::class, 'store']);
    Route::get('payment_term_medium', [PaymentTermMediumsController::class, 'index']);
    Route::post('payment_term_medium', [PaymentTermMediumsController::class, 'store']);
    Route::get('product_discount_rules', [ProductDiscountRulesController::class, 'index']);
    Route::post('product_discount_rules', [ProductDiscountRulesController::class, 'store']);
    Route::get('stocks', [StocksController::class, 'index']);
    Route::post('stocks', [StocksController::class, 'store']);
    Route::get('price_table_products', [PriceTableProductsController::class, 'index']);
    Route::post('price_table_products', [PriceTableProductsController::class, 'store']);
    Route::get('discount_rules', [DiscountRulesController::class, 'index']);
    Route::post('discount_rules', [DiscountRulesController::class, 'store']);
    Route::get('products', [ProductsController::class, 'index']);
    Route::post('products', [ProductsController::class, 'store']);

    Route::get('type_sale_payment_terms', [TypeSalePaymentTermsController::class, 'index']);
    Route::post('type_sale_payment_terms', [TypeSalePaymentTermsController::class, 'store']);

    Route::get('price_tables_payment_terms', [PriceTablePaymentTermsController::class, 'index']);
    Route::post('price_tables_payment_terms', [PriceTablePaymentTermsController::class, 'store']);

    Route::get('sale_delivery_periods', [SaleDeliveryPeriodsController::class, 'index']);
    Route::post('sale_delivery_periods', [SaleDeliveryPeriodsController::class, 'store']);

    Route::get('users', [UsersController::class, 'index']);
    Route::post('users', [UsersController::class, 'store']);

    Route::get('billing_types', [BillingTypesController::class, 'index']);
    Route::post('billing_types', [BillingTypesController::class, 'store']);

    Route::get('billing_type_sellers', [BillingTypeSellersController::class, 'index']);
    Route::post('billing_type_sellers', [BillingTypeSellersController::class, 'store']);

    Route::get('type_sale_billing_types', [TypeSaleBillingTypesController::class, 'index']);
    Route::post('type_sale_billing_types', [TypeSaleBillingTypesController::class, 'store']);

    Route::get('seller_customer', [SellerCustomersController::class, 'index']);
    Route::post('seller_customer', [SellerCustomersController::class, 'store']);


    Route::get('price_table_billing_types', [PriceTableBillingTypesController::class, 'index']);
    Route::post('price_table_billing_types', [PriceTableBillingTypesController::class, 'store']);

    Route::get('customer_billing_types', [CustomerBillingTypesController::class, 'index']);
    Route::post('customer_billing_types', [CustomerBillingTypesController::class, 'store']);

    Route::get('payment_term_billing_types', [PaymentTermBillingTypesController::class, 'index']);
    Route::post('payment_term_billing_types', [PaymentTermBillingTypesController::class, 'store']);

    Route::get('companies', [CompaniesController::class, 'index']);
    Route::post('companies', [CompaniesController::class, 'store']);

    
    Route::get('user_seller', [UserSellersController::class, 'index']);
    Route::post('user_seller', [UserSellersController::class, 'store']);

    Route::get('sales', [SalesController::class, 'index']);
    Route::post('sales', [SalesController::class, 'store']);
    Route::get('sales/digitando', [SalesController::class, 'listaDigitando']);
    Route::post('sales/digitando', [SalesController::class, 'typingStore']);
    
    Route::get('sales/finalizado', [SalesController::class, 'listFinalizado']);

    Route::put('sales/{id}', [SalesController::class, 'update']);
    Route::get('sales/{id}', [SalesController::class, 'ListaVenda']);

    Route::get('/sales/{id}/grouped-by-delivery-period', [SalesController::class, 'groupItemsByDeliveryPeriod']);

    Route::get('/sales/{id}/quebra-item', [SalesController::class, 'listaQuebra']);


});







