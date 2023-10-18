<?php

use App\Role;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::factory()->count(9)->create()->each(function ($user) {
            // Add default employee role
            $user->attachRole(Role::where('name', 'customer')->withoutGlobalScopes()->first()->id);
        });
    }

}
