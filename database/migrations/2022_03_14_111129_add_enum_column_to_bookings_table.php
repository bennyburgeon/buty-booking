<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddEnumColumnToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            
            DB::statement("ALTER TABLE bookings MODIFY COLUMN payment_status ENUM('pending', 'completed', 'partial_payment')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            
            DB::statement("ALTER TABLE packages MODIFY COLUMN weight_unit ENUM('Grams', 'Kgs', 'Pounds')");
        });
    }

}
