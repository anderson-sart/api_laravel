<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToDiscountRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discount_rules', function (Blueprint $table) {
            $table->index(['discount_rule', 'price_table','type_sale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discount_rules', function (Blueprint $table) {
            $table->dropIndex(['discount_rule', 'price_table','type_sale']);
        });
    }
}
