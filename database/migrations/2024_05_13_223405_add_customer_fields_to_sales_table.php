<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerFieldsToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->text('customer_cnpj')->nullable();
            $table->text('customer_email')->nullable();
            $table->text('customer_contact')->nullable();
            $table->text('customer_phone')->nullable();
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
            $table->dropColumn('customer_cnpj');
            $table->dropColumn('customer_email');
            $table->dropColumn('customer_contact');
            $table->dropColumn('customer_phone');
        });
    }
}
