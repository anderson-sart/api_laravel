<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToBillingTypeIdAndSellerIdInBillingTypeSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billing_type_sellers', function (Blueprint $table) {
            $table->index(['billing_type', 'seller'], 'billing_type_sellers_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billing_type_sellers', function (Blueprint $table) {
            $table->dropIndex('billing_type_sellers_index');

        });
    }
}
