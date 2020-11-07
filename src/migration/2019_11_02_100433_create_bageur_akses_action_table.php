<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bageur\Auth\model\menu;

class CreateBageurAksesActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        \DB::statement("
            CREATE VIEW bageur_akses_action 
            AS
            SELECT
                bgr_action.*, 
                bgr_level_akses_action.granted, 
                bgr_level_akses_action.id_level_akses
            FROM
                bgr_action
                LEFT JOIN
                bgr_level_akses_action
                ON 
                bgr_action.id = bgr_level_akses_action.id_action;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("drop view bageur_akses_action;");
    }
}
