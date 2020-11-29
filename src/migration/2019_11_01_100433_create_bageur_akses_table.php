<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bageur\Auth\model\menu;

class CreateBageurAksesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        \DB::statement("
            CREATE VIEW bageur_akses 
            AS
            SELECT
            bgr_level_akses.id AS id,
            bgr_level_akses.sub_id AS sub_id,
            bgr_level_akses.id_level AS id_level,
            bgr_menu.id AS menu_id,
            bgr_menu.nama AS nama,
            bgr_menu.icon AS icon,
            bgr_menu.sub_nama AS sub_nama,
            bgr_menu.judul AS judul,
            bgr_menu.link AS link,
            bgr_menu.seo_link AS seo_link,
            bgr_menu.urutan AS urutan,
            bgr_menu.status AS status,
            bgr_menu.super_admin AS super_admin,
            bgr_level_akses.granted AS granted 
        FROM
            (
            bgr_menu
            LEFT JOIN bgr_level_akses ON ( bgr_menu.id = bgr_level_akses.id_menu ));
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("drop view bageur_akses;");
    }
}
