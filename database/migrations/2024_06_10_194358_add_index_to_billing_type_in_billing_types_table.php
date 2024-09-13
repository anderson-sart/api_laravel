<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToBillingTypeInBillingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billing_types', function (Blueprint $table) {
            $table->index('billing_type'); // Adiciona o índice ao campo billing_type
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billing_types', function (Blueprint $table) {
            $table->dropIndex(['billing_type']); // Remove o índice caso a migration seja revertida
        });
    }
}
