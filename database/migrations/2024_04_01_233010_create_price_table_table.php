<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('price_table')->default(0);
            $table->text('price_table_code')->nullable();
            $table->text('price_table_description')->nullable();
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
        Schema::dropIfExists('price_tables');
    }
}
