<?php

use App\PaymentGatewayCredentials;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $credential = PaymentGatewayCredentials::first();
        $credential->paypal_client_id = 'ARS__T_4RHRztChfydh8z-tHDWT_PJmI2RS4GnCtMnMTSzT0nL1yI_UMYRMgOCnt5boFvCt-fNN1qrob';
        $credential->paypal_secret = 'ELSSquZ72CAJ0gXYKRjyrfuoyY24V6ekBQhJpLwB5CUzTwxZDnado2qq8sPiHWa4Qu81ubqLNSaqWcts';
        $credential->paypal_status = 'active';

        $credential->stripe_client_id = 'pk_test_XeJ2y9i0TT6HBXxGlR3ghnNw';
        $credential->stripe_secret = 'sk_test_TN006GLuMnvnzxW5JNeq2xgW';
        $credential->stripe_webhook_secret = '';
        $credential->stripe_status = 'active';
        $credential->save();

    }

}
