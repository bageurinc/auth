<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Bageur\Auth\Model\user;

class BgrUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_level');
            $table->string('name');
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->string('foto')->nullable();
            $table->string('foto_path')->nullable();
            $table->json('addons')->nullable();
            $table->boolean('status')->default(1);
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
