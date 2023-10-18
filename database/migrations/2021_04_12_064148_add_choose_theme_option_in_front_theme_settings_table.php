<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class AddChooseThemeOptionInFrontThemeSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('front_theme_settings', function (Blueprint $table) {
            $table->enum('front_theme', ['theme-1', 'theme-2'])->default('theme-2')->after('seo_keywords');
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
            $table->dropColumn('front_theme');
        });
    }

}
