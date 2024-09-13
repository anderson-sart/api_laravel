<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('product')->nullable();
            $table->text('product_description')->nullable();
            $table->text('product_code')->nullable();
            $table->text('color')->nullable();
            $table->text('size')->nullable();
            $table->text('list_multiples')->nullable();
            $table->text('bar_code')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('status',1)->nullable();
            // Adicione outras colunas conforme necessário

            $table->timestamps(); // Adiciona as colunas 'created_at' e 'updated_at'
            $table->softDeletes();


                        
            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
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
        Schema::dropIfExists('products');
    }
}
