<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldAsFullfilledInWpOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_order_products', function (Blueprint $table) {
            $table->boolean('is_fulfilled')->default(0)->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_order_products', function (Blueprint $table) {
            $table->dropColumn('is_fulfilled');
        });
    }
}
