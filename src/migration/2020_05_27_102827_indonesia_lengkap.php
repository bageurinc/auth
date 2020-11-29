<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndonesiaLengkap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('bgr_indonesia_jenis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
        });

       Schema::create('bgr_indonesia_provinsi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
        });

       Schema::create('bgr_indonesia_kabupaten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_prov');
            $table->string('nama');
            $table->foreignId('jenis_id');
        });


       Schema::create('bgr_indonesia_kecamatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kab');
            $table->string('nama');
        });

       Schema::create('bgr_indonesia_kelurahan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kec');
            $table->string('nama');
            $table->foreignId('jenis_id');
        });

       \DB::unprepared(file_get_contents(__DIR__.'/indonesia.sql'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bgr_indonesia_jenis');
        Schema::dropIfExists('bgr_indonesia_provinsi');
        Schema::dropIfExists('bgr_indonesia_kabupaten');
        Schema::dropIfExists('bgr_indonesia_kecamatan');
        Schema::dropIfExists('bgr_indonesia_kelurahan');
    }
}
