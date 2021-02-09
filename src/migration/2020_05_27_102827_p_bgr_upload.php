<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Bageur\Auth\Model\user;

class PBgrUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_upload', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('uuid');
            $table->uuid('bgr_upload_id')->nullable();
            $table->uuid('group')->nullable();
            $table->string('folder')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('bgr_user');
    }
}
