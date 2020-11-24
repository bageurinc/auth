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
       \DB::unprepared(__DIR__.'/migration/indonesia.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
