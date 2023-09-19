<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateToAdvertisementBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('advertisement_banners', function (Blueprint $table) {
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('end_date_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertisement_banners', function (Blueprint $table) {
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('end_date_time')->nullable();
        });
    }

}
