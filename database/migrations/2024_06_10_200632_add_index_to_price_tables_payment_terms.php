<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToPriceTablesPaymentTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_tables_payment_terms', function (Blueprint $table) {
            $table->index(['price_table', 'payment_term'], 'price_tables_payment_terms_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_tables_payment_terms', function (Blueprint $table) {
            $table->dropIndex('price_tables_payment_terms_index');
        });
    }
}
