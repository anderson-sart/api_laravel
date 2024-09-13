<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Adiciona uma coluna 'id' autoincrementável como chave primária
            $table->integer('customer')->default(0);
            $table->text('cpf_cnpj')->nullable();
            $table->text('corporate_name')->nullable();
            $table->text('nickname')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->integer('city')->nullable();
            $table->string('expired_financial_title',1)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
