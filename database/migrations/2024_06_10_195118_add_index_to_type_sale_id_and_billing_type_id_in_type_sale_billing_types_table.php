<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToTypeSaleIdAndBillingTypeIdInTypeSaleBillingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_sale_billing_types', function (Blueprint $table) {
            $table->index(['billing_type', 'type_sale'], 'type_sale_billing_types_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_sale_billing_types', function (Blueprint $table) {
            $table->dropIndex('type_sale_billing_types_index');
        });
    }
}
