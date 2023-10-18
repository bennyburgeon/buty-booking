<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SeoDetailsInFrontThemeSettings extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('front_theme_settings', function (Blueprint $table) {
            $table->string('seo_description')->after('carousel_status');
            $table->string('seo_keywords')->after('seo_description');
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
            $table->dropColumn(['seo_description', 'seo_keywords']);
        });
    }

}
