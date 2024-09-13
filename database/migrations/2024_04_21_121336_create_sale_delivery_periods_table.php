<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDeliveryPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_delivery_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_delivery_period')->nullable();
            $table->date('initial_date')->nullable();
            $table->date('final_date')->nullable();
            $table->timestamp('date_change')->nullable();
            $table->text('description_period')->nullable();
            $table->date('data_reference')->nullable();
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
        Schema::dropIfExists('sale_delivery_periods');
    }
}
