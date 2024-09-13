<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTermMedium extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_term_medium', function (Blueprint $table) {
            $table->id();
            $table->decimal('payment_term_medium', 10, 3)->default(0);
            $table->decimal('minimum_discount_percentage', 10, 3)->default(0);
            $table->decimal('maximum_discount_percentage', 10, 3)->default(0);
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
        Schema::dropIfExists('payment_term_medium');
    }
}
