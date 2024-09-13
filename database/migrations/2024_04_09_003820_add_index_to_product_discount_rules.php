<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToProductDiscountRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_discount_rules', function (Blueprint $table) {
            $table->index(['product_discount_rule', 'price_table']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_discount_rules', function (Blueprint $table) {
            $table->dropIndex(['product_discount_rule', 'price_table']);
        });
    }
}
