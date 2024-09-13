<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    
    {
        $this->app->bind('App\\Repositories\\Interfaces\\BaseRepositoryInterface', 'App\\Repositories\\Implementation\\BaseRepository');
        $this->app->bind('App\Repositories\Interfaces\PaymentTermsRepositoryInterface', 'App\\Repositories\Implementation\PaymentTermsRepository');
        $this->app->bind('App\Repositories\Interfaces\PaymentTermMediumsRepositoryInterface', 'App\\Repositories\Implementation\PaymentTermMediumsRepository');
        $this->app->bind('App\Repositories\Interfaces\TypeSalesRepositoryInterface', 'App\\Repositories\Implementation\TypeSalesRepository');
        $this->app->bind('App\Repositories\Interfaces\PriceTablesRepositoryInterface', 'App\\Repositories\Implementation\PriceTablesRepository');
        $this->app->bind('App\Repositories\Interfaces\CustomersRepositoryInterface', 'App\\Repositories\Implementation\CustomersRepository');
        $this->app->bind('App\Repositories\Interfaces\ColorsRepositoryInterface', 'App\\Repositories\Implementation\ColorsRepository');
        $this->app->bind('App\Repositories\Interfaces\SizesRepositoryInterface', 'App\\Repositories\Implementation\SizesRepository');
        $this->app->bind('App\Repositories\Interfaces\AssetsRepositoryInterface', 'App\\Repositories\Implementation\AssetsRepository');
        $this->app->bind('App\Repositories\Interfaces\UsersRepositoryInterface', 'App\\Repositories\Implementation\UsersRepository');
        $this->app->bind('App\Repositories\Interfaces\BrandsRepositoryInterface', 'App\\Repositories\Implementation\BrandsRepository');
        $this->app->bind('App\Repositories\Interfaces\SellersRepositoryInterface', 'App\\Repositories\Implementation\SellersRepository');
        $this->app->bind('App\Repositories\Interfaces\CarriersRepositoryInterface', 'App\\Repositories\Implementation\CarriersRepository');
        $this->app->bind('App\Repositories\Interfaces\CompaniesRepositoryInterface', 'App\\Repositories\Implementation\CompaniesRepository');
        $this->app->bind('App\Repositories\Interfaces\ProductDiscountRulesRepositoryInterface', 'App\\Repositories\Implementation\ProductDiscountRulesRepository');
        $this->app->bind('App\Repositories\Interfaces\StocksRepositoryInterface', 'App\\Repositories\Implementation\StocksRepository');
        $this->app->bind('App\Repositories\Interfaces\ProductsRepositoryInterface', 'App\\Repositories\Implementation\ProductsRepository');
        $this->app->bind('App\Repositories\Interfaces\PriceTableProductsRepositoryInterface', 'App\\Repositories\Implementation\PriceTableProductsRepository');
        $this->app->bind('App\Repositories\Interfaces\DiscountRulesRepositoryInterface', 'App\\Repositories\Implementation\DiscountRulesRepository');
        $this->app->bind('App\Repositories\Interfaces\SaleDeliveryPeriodsRepositoryInterface', 'App\\Repositories\Implementation\SaleDeliveryPeriodsRepository');
        $this->app->bind('App\Repositories\Interfaces\TypeSalePaymentTermsRepositoryInterface', 'App\\Repositories\Implementation\TypeSalePaymentTermsRepository');
        $this->app->bind('App\Repositories\Interfaces\PriceTablePaymentTermsRepositoryInterface', 'App\\Repositories\Implementation\PriceTablePaymentTermsRepository');
        $this->app->bind('App\Repositories\Interfaces\BillingTypesRepositoryInterface', 'App\\Repositories\Implementation\BillingTypesRepository');
        $this->app->bind('App\Repositories\Interfaces\BillingTypeSellersRepositoryInterface', 'App\\Repositories\Implementation\BillingTypeSellersRepository');
        $this->app->bind('App\Repositories\Interfaces\TypeSaleBillingTypesRepositoryInterface', 'App\\Repositories\Implementation\TypeSaleBillingTypesRepository');
        $this->app->bind('App\Repositories\Interfaces\SellerCustomersRepositoryInterface', 'App\\Repositories\Implementation\SellerCustomersRepository');
        $this->app->bind('App\Repositories\Interfaces\UserSellersRepositoryInterface', 'App\\Repositories\Implementation\UserSellersRepository');
        $this->app->bind('App\Repositories\Interfaces\PaymentTermBillingTypesRepositoryInterface', 'App\\Repositories\Implementation\PaymentTermBillingTypesRepository');
        $this->app->bind('App\Repositories\Interfaces\CustomerBillingTypesRepositoryInterface', 'App\\Repositories\Implementation\CustomerBillingTypesRepository');
        $this->app->bind('App\Repositories\Interfaces\PriceTableBillingTypesRepositoryInterface', 'App\\Repositories\Implementation\PriceTableBillingTypesRepository');


        $this->app->bind('App\Repositories\Interfaces\SalesRepositoryInterface', 'App\\Repositories\Implementation\SalesRepository');
        $this->app->bind('App\Repositories\Interfaces\SaleItemsRepositoryInterface', 'App\\Repositories\Implementation\SaleItemsRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
