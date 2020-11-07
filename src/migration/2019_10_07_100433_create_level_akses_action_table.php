<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bageur\Auth\model\menu;

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
