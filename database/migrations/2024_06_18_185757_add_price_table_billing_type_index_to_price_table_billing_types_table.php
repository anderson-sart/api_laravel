<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceTableBillingTypeIndexToPriceTableBillingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_table_billing_types', function (Blueprint $table) {
            $table->index(['billing_type', 'price_table'], 'price_table_billing_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_table_billing_types', function (Blueprint $table) {
            $table->dropIndex('price_table_billing_index');
        });
    }
}
