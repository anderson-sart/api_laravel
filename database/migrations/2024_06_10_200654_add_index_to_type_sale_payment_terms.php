<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToTypeSalePaymentTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type_sale_payment_terms', function (Blueprint $table) {
            $table->index(['type_sale', 'payment_term'], 'seller_customer_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_sale_payment_terms', function (Blueprint $table) {
            $table->dropIndex('seller_customer_index');
        });
    }
}
