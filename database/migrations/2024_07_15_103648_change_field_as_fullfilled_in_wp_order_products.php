<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldAsFullfilledInWpOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_order_products', function (Blueprint $table) {
            $table->integer('is_fulfilled')->default(0)->comment('1. fullfilled , 2. rejected 3.passed By Admin 4.Rejected By admin 5.cancelled By Customer')->change();
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
            $table->integer('is_fulfilled')->default(0)-> comment('1. fullfilled , 2. rejected 3.passed By Admin 4.Rejected By admin 5.cancelled By Customer')
                ->change();
        });
    }
}
