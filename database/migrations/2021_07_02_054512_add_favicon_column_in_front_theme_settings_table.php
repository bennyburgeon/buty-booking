<?php

use App\FrontThemeSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFaviconColumnInFrontThemeSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('front_theme_settings', function (Blueprint $table) {
            $table->string('title')->after('id')->nullable();
            $table->string('favicon')->after('logo')->nullable();
            $table->string('custom_js')->after('custom_css')->nullable();
        });

        $theme = FrontThemeSetting::first();

        if($theme){
            $theme->title  = 'Appointo';
            $theme->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('front_theme_settings', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('favicon');
            $table->dropColumn('custom_js');
        });
    }

}
