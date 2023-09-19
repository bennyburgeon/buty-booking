<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CategoryTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @test
     * @return void
     */

    public function categoryTestExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertSee('Sign in your Account')
                ->type('email', 'admin@example.com')
                ->type('password', '123456')
                ->press('Sign In')
                ->pause(4000)
                ->assertPathIs('/account/dashboard')
                ->waitForLink('Categories')
                ->clickLink('Categories')
                ->pause(2000)
                ->waitForLink('Create New')
                ->clickLink('Create New')
                ->assertPathIs('/account/categories/create')
                ->typeSlowly('name', 'New Category'.rand(0, 9999))
                ->press('Save')
                ->pause(2000)
                ->waitFor('.fa-pencil')
                ->click('.fa-pencil')
                ->typeSlowly('name', 'Category Updated'.rand(0, 9999))
                ->press('Save')
                ->pause(2000)
                ->waitFor('.fa-times')
                ->click('.fa-times')
                ->pause(2000)
                ->press('OK')
                ->pause(4000);
        });
    }

}
