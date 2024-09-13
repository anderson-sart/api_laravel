<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_rules', function (Blueprint $table) {
            $table->id();
            $table->integer('discount_rule');
            $table->text('discount_rule_description')->nullable();
            $table->decimal('minimum_discount_percentage', 10, 3)->default(0);
            $table->decimal('maximum_discount_percentage', 10, 3)->default(0);
            $table->decimal('range_sale_value', 10, 3)->default(0);
            $table->decimal('range_sale_quantity', 10, 3)->default(0);
            $table->integer('price_table')->nullable();
            $table->string('type_sale',100)->nullable();
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
        Schema::dropIfExists('discount_rules');
    }
}
