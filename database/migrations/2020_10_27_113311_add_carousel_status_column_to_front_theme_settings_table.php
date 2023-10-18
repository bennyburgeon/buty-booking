<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCarouselStatusColumnToFrontThemeSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('front_theme_settings', function (Blueprint $table) {
            $table->enum('carousel_status', ['enabled', 'disabled'])->default('enabled')->after('logo');
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
            $table->dropColumn('carousel_status');
        });
    }

}
