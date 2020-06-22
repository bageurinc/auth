<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('level_menus');
    }
}
