<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bageur\Auth\model\menu;

class CreateActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_action', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('menu_id')->index()->nullable();
            $table->string('nama')->nullable();
            $table->string('route')->nullable();
            $table->string('icon');
            $table->string('icon_vendor')->default('mdi');
            $table->boolean('status')->default(true);
            $table->boolean('show')->default(true);
            $table->tinyInteger('urutan',2);
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
        Schema::dropIfExists('bgr_action');
    }
}
