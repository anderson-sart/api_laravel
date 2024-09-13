<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToSaleDeliveryPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sale_delivery_periods', function (Blueprint $table) {
            $table->index(['sale_delivery_period']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sale_delivery_periods', function (Blueprint $table) {
            $table->dropIndex(['sale_delivery_period']);
        });
    }
}
