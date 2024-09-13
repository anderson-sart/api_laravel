<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->text('sale_code')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('price_table_id')->nullable();
            $table->unsignedBigInteger('type_sale_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('payment_term_id')->nullable();
            $table->date('delivery_date')->nullable();
            $table->decimal('gross_total_amount', 10, 3)->nullable();;
            $table->decimal('total_amount', 10, 3)->nullable();
            $table->decimal('total_discount_amount', 10, 3)->nullable();
            $table->date('emission_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('carrier_id')->nullable();
            $table->text('observation')->nullable();
            $table->decimal('perc_desconto_1', 10, 3)->nullable();
            $table->decimal('perc_desconto_2', 10, 3)->nullable();
            $table->string('status',1)->nullable();
            // Adicione outras colunas conforme necessário

            $table->timestamps(); // Adiciona as colunas 'created_at' e 'updated_at'
            $table->softDeletes();

            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onDelete('restrict'); 

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('restrict');
            
            $table->foreign('seller_id')
                ->references('id')
                ->on('sellers')
                ->onDelete('restrict');

            $table->foreign('price_table_id')
                ->references('id')
                ->on('price_tables')
                ->onDelete('restrict');

            $table->foreign('type_sale_id')
                ->references('id')
                ->on('type_sales')
                ->onDelete('restrict'); 
            
            $table->foreign('payment_term_id')
                ->references('id')
                ->on('payment_terms')
                ->onDelete('restrict'); 

            $table->foreign('carrier_id')
                ->references('id')
                ->on('carriers')
                ->onDelete('restrict'); 
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
