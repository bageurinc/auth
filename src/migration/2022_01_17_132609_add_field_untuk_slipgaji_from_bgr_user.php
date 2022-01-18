<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldUntukSlipgajiFromBgrUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bgr_user', function (Blueprint $table) {
            $table->string('jabatan')->nullable();
            $table->date('tanggalmasuk')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('no_rek')->nullable();
            $table->string('nama_pemilik')->nullable();
            $table->integer('jumlah_pinjaman')->nullable();
            $table->integer('sisa_pinjaman')->nullable();
            $table->integer('pinjaman_belum_dibayar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bgr_user', function (Blueprint $table) {
            //
        });
    }
}
