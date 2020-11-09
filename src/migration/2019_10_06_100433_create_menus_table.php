<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bageur\Auth\model\menu;

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
            $table->string('judul');
            $table->string('link');
            $table->text('seo_link');
            $table->double('urutan')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('super_admin')->default(false);
            $table->timestamps();
        });

        $menu = new menu;
        $menu->id                 = 1;
        $menu->nama               = 'Home';
        $menu->judul              = 'Home';
        $menu->link               = 'home';
        $menu->seo_link           = 'home';
        $menu->urutan               = 1;
        $menu->status               = 1;
        $menu->save();

        $menu = new menu;
        $menu->id                 = 2;
        $menu->nama               = 'pengaturan';
        $menu->judul              = 'pengaturan';
        $menu->link               = 'pengaturan';
        $menu->seo_link           = 'pengaturan';
        $menu->urutan             = 1;
        $menu->status             = 1;
        $menu->save();

        $menu = new menu;
        $menu->id                 = 3;
        $menu->nama               = 'Menu';
        $menu->judul              = 'Menu';
        $menu->link               = 'pengaturan-menu';
        $menu->seo_link           = 'pengaturan-menu';
        $menu->urutan             = 1;
        $menu->status             = 1;
        $menu->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bgr_menu');
    }
}
