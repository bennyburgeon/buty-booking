<?php

use App\CompanySetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGetstartedNoteColumnInCompanySettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->text('get_started_title')->nullable()->after('booking_time_type');
            $table->text('get_started_note')->nullable()->after('get_started_title');
        });

        $get_started_note = CompanySetting::first();

        if(!is_null($get_started_note)) {

            $get_started_note->get_started_title  = 'Lorem Ipsum Dolor';
            $get_started_note->get_started_note  = 'Lorem ipsum dolor sit amet, consectetur adipiscing elitaccumsan lacus.';
            $get_started_note->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn('get_started_title');
            $table->dropColumn('get_started_note');
        });
    }

}
