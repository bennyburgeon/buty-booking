<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleOAuthIdsToCompanySettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->enum('google_calendar', ['active', 'deactive'])->default('deactive');
            $table->text('google_client_id')->nullable();
            $table->text('google_client_secret')->nullable();

            // Data.
            $table->string('google_id')->nullable();
            $table->string('name')->nullable();
            $table->longText('token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn('google_calendar');
            $table->dropColumn('google_client_id');
            $table->dropColumn('google_client_secret');
            $table->dropColumn('google_id');
            $table->dropColumn('name');
            $table->dropColumn('token');
        });
    }

}
