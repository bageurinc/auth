<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bageur\Auth\model\level_akses_action;

class CreateLevelAksesActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_level_akses_action', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_level_akses')->index();
            $table->bigInteger('id_action')->index();
            $table->boolean('granted')->default(false);
            $table->timestamps();

            $table->foreign('id_level_akses')->references('id')
                                         ->on('bgr_level_akses')
                                         ->onDelete('cascade');
        });

        // $action                         = new level_akses_action;
        // $action->id_level_akses         = 3;
        // $action->id_action              = 1;
        // $action->granted                = 1;
        // $action->save();

        // $action                         = new level_akses_action;
        // $action->id_level_akses         = 3;
        // $action->id_action              = 2;
        // $action->granted                = 1;
        // $action->save();

        // $action                         = new level_akses_action;
        // $action->id_level_akses         = 3;
        // $action->id_action              = 3;
        // $action->granted                = 1;
        // $action->save();
        
        // $action                         = new level_akses_action;
        // $action->id_level_akses         = 3;
        // $action->id_action              = 4;
        // $action->granted                = 1;
        // $action->save();

        // $action                         = new level_akses_action;
        // $action->id_level_akses         = 3;
        // $action->id_action              = 5;
        // $action->granted                = 1;
        // $action->save();

        // $action                         = new level_akses_action;
        // $action->id_level_akses         = 3;
        // $action->id_action              = 6;
        // $action->granted                = 1;
        // $action->save();

        // $action                         = new level_akses_action;
        // $action->id_level_akses         = 3;
        // $action->id_action              = 7;
        // $action->granted                = 1;
        // $action->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bgr_level_akses_action');
    }
}
