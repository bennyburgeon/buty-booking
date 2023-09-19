<?php

use App\Module;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        if(Module::where('name', 'advertisement_banner')->get()->count() == 0)
        {
            $module = new Module();
            $module->name = 'advertisement_banner';
            $module->display_name = 'Advertisement Banner';
            $module->description = 'modules.module.advertisementDescription';
            $module->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $modules = Module::select('id', 'name')->whereIn('name', 'advertisement_banner')->get();

        foreach ($modules as $module) {
            $module->delete();
        }
    }

}
