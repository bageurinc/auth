<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bageur\Auth\model\level;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_level', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->boolean('status')->default(true);
            $table->boolean('super_admin')->default(false);
            $table->timestamps();
        });

        $level = new level;
        $level->id               = 1;
        $level->nama             = 'super admin';
        $level->status           = 1;
        $level->super_admin      = 1;
        $level->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bgr_level');
    }
}
