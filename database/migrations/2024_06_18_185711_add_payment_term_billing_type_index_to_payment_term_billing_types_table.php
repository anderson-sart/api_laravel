<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTermBillingTypeIndexToPaymentTermBillingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_term_billing_types', function (Blueprint $table) {
            $table->index(['billing_type', 'payment_term'], 'payment_term_billing_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_term_billing_types', function (Blueprint $table) {
            $table->dropIndex('payment_term_billing_index');
        });
    }
}
