<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCarouselAutoplayToFrontThemeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('front_theme_settings', function (Blueprint $table) {
            $table->enum('carousel_autoplay', ['enabled', 'disabled'])->default('enabled')->after('carousel_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('front_theme_settings', function (Blueprint $table) {
            $table->dropColumn('carousel_autoplay');
        });
    }

}
