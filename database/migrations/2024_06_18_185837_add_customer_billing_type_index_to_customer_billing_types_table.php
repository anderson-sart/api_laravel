<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerBillingTypeIndexToCustomerBillingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_billing_types', function (Blueprint $table) {
            $table->index(['customer', 'billing_type'], 'customer_billing_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_billing_types', function (Blueprint $table) {
            $table->dropIndex('customer_billing_index');
        });
    }
}
