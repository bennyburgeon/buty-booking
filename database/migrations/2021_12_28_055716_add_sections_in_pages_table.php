<?php

use App\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionsInPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->enum('section', ['who we are', 'support'])->nullable();

        });

        $pages = Page::all();

        foreach($pages as $page){

            $page->section = $page->id !== 1 && $page->id !== 3 && $page->id !== 5 ? 'support' : 'who we are';
            $page->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {

        });
    }

}
