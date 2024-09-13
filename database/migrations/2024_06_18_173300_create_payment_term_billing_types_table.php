<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTermBillingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_term_billing_types', function (Blueprint $table) {
            $table->id();
            $table->integer('billing_type')->default(0);
            $table->integer('payment_term')->default(0);
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
        Schema::dropIfExists('payment_term_billing_types');
    }
}
