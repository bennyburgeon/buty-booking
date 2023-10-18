<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaystackToPaymentTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_gateway_credentials', function (Blueprint $table) {
            $table->string('paystack_public_id')->nullable()->after('stripe_status');
            $table->string('paystack_secret_id')->nullable()->after('paystack_public_id');
            $table->string('paystack_webhook_secret')->nullable()->default(null)->after('paystack_secret_id');
            $table->enum('paystack_status', ['active', 'deactive'])->default('deactive')->after('paystack_webhook_secret');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_gateway_credentials', function (Blueprint $table) {
            $table->dropColumn('paystack_public_id');
            $table->dropColumn('paystack_secret_id');
            $table->dropColumn('paystack_webhook_secret');
            $table->dropColumn('paystack_status');
        });
    }

}
