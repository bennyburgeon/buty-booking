<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountTypeColumnToCouponsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->enum('discount_type', ['percentage', 'amount'])->default('percentage')->after('amount');

        });

        Schema::table('coupons', function($table) {
            $table->dropColumn('percent');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

}
