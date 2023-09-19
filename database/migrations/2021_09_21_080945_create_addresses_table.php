<?php

use App\Address;
use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('SET NULL')->onUpdate('cascade');
            $table->unsignedInteger('house_no')->nullable();
            $table->longText('address_line')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->unsignedInteger('pin_code')->nullable();
            $table->timestamps();
        });

        $users = User::all();

        foreach ($users as $user) {
            $address = new Address();
            $address->user_id = $user->id;
            $address->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }

}
