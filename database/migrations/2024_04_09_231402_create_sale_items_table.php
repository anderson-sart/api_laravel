<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->text('sale_item_code')->nullable();
            $table->text('sale_code')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->text('off_product')->nullable();
            $table->text('off_color')->nullable();
            $table->text('off_size')->nullable();
            $table->integer('sequence')->nullable();
            $table->integer('multiple')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->decimal('total_perc_discount', 10, 3)->default(0);
            $table->decimal('unitary_price', 10, 3)->default(0);
            $table->decimal('gross_total_amount_item', 10, 3)->default(0);
            $table->decimal('total_amount_item', 10, 3)->default(0);
            $table->decimal('total_discount_amount_item', 10, 3)->default(0);
            $table->decimal('discount_percentage', 10, 3)->nullable();
            $table->string('status',1)->nullable();
            // Adicione outras colunas conforme necessário

            $table->timestamps(); // Adiciona as colunas 'created_at' e 'updated_at'
            $table->softDeletes();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
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
        Schema::dropIfExists('sale_items');
    }
}
