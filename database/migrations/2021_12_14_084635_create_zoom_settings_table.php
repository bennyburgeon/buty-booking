<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateZoomSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('zoom_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('api_key', 50)->nullable();
            $table->string('secret_key', 50)->nullable();
            $table->string('purchase_code')->nullable();
            $table->string('meeting_app');
            $table->timestamp('supported_until')->nullable();
            $table->enum('enable_zoom', ['active', 'inactive']);
            $table->timestamps();
        });

        $data = [
            'api_key' => null,
            'secret_key' => null,
            'purchase_code' => null,
            'supported_until' => null,
            'meeting_app' => 'in_app',
            'enable_zoom' => 'inactive'
        ];

        DB::table('zoom_settings')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zoom_settings');
    }

}
