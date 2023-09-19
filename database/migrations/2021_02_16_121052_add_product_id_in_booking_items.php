<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdInBookingItems extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_items', function (Blueprint $table) {

            $table->dropForeign(['business_service_id']);
            $table->unsignedInteger('business_service_id')->nullable()->change();
            $table->foreign('business_service_id')->references('id')->on('business_services')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('product_id')->nullable()->after('business_service_id');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_items', function (Blueprint $table) {
            //
        });
    }

}
