<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->text('off_seller')->nullable();
            $table->text('off_customer')->nullable();
            $table->text('off_price_table')->nullable();
            $table->text('off_type_sale')->nullable();
            $table->text('off_brand')->nullable();       
            $table->text('off_payment_term')->nullable();       
            $table->text('off_user')->nullable();       
            $table->text('off_carrier')->nullable();       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('off_seller');
            $table->dropColumn('off_customer');
            $table->dropColumn('off_price_table');
            $table->dropColumn('off_type_sale');
            $table->dropColumn('off_brand');
            $table->dropColumn('off_payment_term');
            $table->dropColumn('off_user');
            $table->dropColumn('off_carrier');
        });
    }
}
