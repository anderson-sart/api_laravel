<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // Adiciona uma coluna 'id' autoincrementável como chave primária
            $table->integer('company')->default(0);
            $table->text('cpf_cnpj')->nullable();
            $table->text('company_name')->nullable();
            $table->text('nickname')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->integer('city')->nullable();
            $table->text('event_description')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
