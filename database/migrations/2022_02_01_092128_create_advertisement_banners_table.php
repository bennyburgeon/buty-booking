<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('advertisement_banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('position');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive', 'expire'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::dropIfExists('advertisement_banners');
    }

}
