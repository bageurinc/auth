<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bageur\Auth\model\level_menu;

class CreateLevelMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_level_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_level')->index();
            $table->bigInteger('id_menu')->index();
            $table->bigInteger('id_submenu')->index()->nullable();
            $table->boolean('disabled')->default(false);
            $table->boolean('view')->default(true);
            $table->timestamps();
        });

        $level_menu              = new level_menu;
        $level_menu->id_level    = 1;
        $level_menu->id_menu     = 1;
        $level_menu->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bgr_level_menu');
    }
}
