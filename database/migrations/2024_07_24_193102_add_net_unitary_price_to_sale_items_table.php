<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNetUnitaryPriceToSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->decimal('net_unitary_price', 8, 3)->nullable()->after('unitary_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropColumn('net_unitary_price');
        });
    }
}
