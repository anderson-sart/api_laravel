<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceTableProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_table_products', function (Blueprint $table) {
            $table->id();
            $table->string('product',100)->nullable();
            $table->integer('price_table')->default(0);
            $table->decimal('price', 10, 3)->default(0);
            $table->string('status',1)->nullable();
            // Adicione outras colunas conforme necessário

            $table->timestamps(); // Adiciona as colunas 'created_at' e 'updated_at'
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_table_products');
    }
}
