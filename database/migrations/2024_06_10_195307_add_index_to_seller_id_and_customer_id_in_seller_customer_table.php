<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToSellerIdAndCustomerIdInSellerCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_customer', function (Blueprint $table) {
            $table->index(['seller', 'customer'], 'seller_customer_index');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_customer', function (Blueprint $table) {
            $table->dropIndex('seller_customer_index');
        });
    }
}
