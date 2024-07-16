<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->after('email')->nullable();
            $table->string('company_name')->after('status')->nullable();
            $table->string('pincode')->after('company_name')->nullable();
            $table->string('state')->after('pincode')->nullable();
            $table->string('city')->after('state')->nullable();
            $table->string('address')->after('city')->nullable();
            $table->string('website')->after('address')->nullable();
            $table->string('gst_number')->after('website')->nullable();
            $table->string('term&condition')->after('gst_number')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone');
            $table->string('company_name');
            $table->string('pincode');
            $table->string('state');
            $table->string('city');
            $table->string('address');
            $table->string('website');
            $table->string('gst_number');
        });
    }
}
