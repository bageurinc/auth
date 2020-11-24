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
