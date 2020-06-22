<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sub_id')->index()->nullable();
            $table->string('nama')->nullable();
            $table->string('icon')->nullable();
            $table->string('sub_nama')->nullable();
            $table->string('judul')->default('Darjeeling');
            $table->string('link');
            $table->string('action'); //view , edit , tambah , detail , delete dll
            $table->text('seo_link');
            $table->double('urutan')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('menus');
    }
}
