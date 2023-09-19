<?php

use Illuminate\Database\Seeder;
use App\EmployeeGroup;
use App\Role;
use App\User;

class EmployeeSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert employee groups
        $user = new EmployeeGroup();
        $user->name = 'Hair Stylist';
        $user->save();


        $user = new EmployeeGroup();
        $user->name = 'Skin Specialist';
        $user->save();


        $user = new EmployeeGroup();
        $user->name = 'Therapists';
        $user->save();


        // Insert employees
        $user = new User();
        $user->name     = 'Malik Griffith';
        $user->email    = 'coweryl@example.com';
        $user->group_id = 2;
        $user->password = '123456';
        $user->mobile = '1111';
        $user->save();

        // Add default employee role
        $user->attachRole(Role::where('name', 'employee')->first()->id);

        $user = new User();
        $user->name     = 'Dara Hancock';
        $user->email    = 'fytafacyly@example.com';
        $user->group_id = 1;
        $user->password = '123456';
        $user->mobile = '1111';
        $user->save();

        // Add default employee role
        $user->attachRole(Role::where('name', 'employee')->first()->id);
    }

}
