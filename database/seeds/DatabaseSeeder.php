<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(DefaultAdminSeeder::class);

        if (!App::environment('codecanyon')) {
            $this->call(CategorySeeder::class);
            $this->call(ProductSeeder::class);
            $this->call(UserSeeder::class);
            $this->call(BookingSeeder::class);
            $this->call(EmployeeSeeder::class);
            $this->call(PaymentSeeder::class);
            $this->call(PaymentGatewaySeeder::class);
            $this->call(EmployeeScheduleSeeder::class);
            $this->call(ProductSeeder::class);

        }
    }

}
