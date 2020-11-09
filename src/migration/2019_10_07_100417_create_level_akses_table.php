<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bageur\Auth\model\level_akses;

class CreateLevelAksesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_level_akses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_level')->index();
            $table->unsignedBigInteger('id_menu')->index();
            $table->bigInteger('sub_id')->index()->nullable();
            $table->boolean('granted')->default(false);
            $table->timestamps();
            
            $table->foreign('id_menu')->references('id')
                                         ->on('bgr_menu')
                                         ->onUpdate('cascade')
                                         ->onDelete('cascade');
            
            $table->foreign('id_level')->references('id')
                                         ->on('bgr_level')
                                         ->onUpdate('cascade')
                                         ->onDelete('cascade');
        });

        // $menu                     = new level_akses;
        // $menu->id                 = 1;
        // $menu->id_level           = 1;
        // $menu->id_menu            = 1;
        // $menu->granted            = 1;
        // $menu->save();

        // $menu                     = new level_akses;
        // $menu->id                 = 2;
        // $menu->id_level           = 1;
        // $menu->id_menu            = 2;
        // $menu->granted            = 1;
        // $menu->save();

        // $menu                     = new level_akses;
        // $menu->id                 = 3;
        // $menu->id_level           = 1;
        // $menu->id_menu            = 3;
        // $menu->sub_id             = 2;
        // $menu->granted            = 1;
        // $menu->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bgr_level_akses');
    }
}
