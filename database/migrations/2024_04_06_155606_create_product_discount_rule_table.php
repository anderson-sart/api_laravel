<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDiscountRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_discount_rules', function (Blueprint $table) {
            $table->id();
            $table->integer('product_discount_rule')->nullable();
            $table->string('product',100)->nullable();
            $table->string('color',50)->nullable();
            $table->integer('price_table');
            $table->text('discount_perc_type')->nullable();
            $table->decimal('minimum_discount_percentage', 10, 3)->default(0);
            $table->decimal('maximum_discount_percentage', 10, 3)->default(0);
            $table->decimal('range_sale_value', 10, 3)->default(0);
            $table->decimal('range_sale_quantity', 10, 3)->default(0);
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
        Schema::dropIfExists('product_discount_rules');
    }
}
