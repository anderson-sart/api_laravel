<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_sales', function (Blueprint $table) {
            $table->id();
            $table->string('type_sale',50)->nullable();
            $table->text('type_sale_description')->nullable();
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
        Schema::dropIfExists('type_sales');
    }
}
