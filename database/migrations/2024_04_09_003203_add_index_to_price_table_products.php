<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToPriceTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_table_products', function (Blueprint $table) {
            $table->index(['product', 'price_table'], 'price_table_products_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_table_products', function (Blueprint $table) {
            $table->dropIndex('price_table_products_index');
        });
    }
}
