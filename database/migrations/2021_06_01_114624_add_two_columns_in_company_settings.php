<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTwoColumnsInCompanySettings extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->enum('cron_status', ['active', 'deactive'])->default('deactive');
            $table->integer('duration')->default(1);
            $table->enum('duration_type', ['minutes', 'hours', 'days', 'weeks'])->default('minutes');
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
            $table->dropColumn('cron_status');
            $table->dropColumn('day');
            $table->dropColumn('hour');
            $table->dropColumn('minute');

        });
    }

}
