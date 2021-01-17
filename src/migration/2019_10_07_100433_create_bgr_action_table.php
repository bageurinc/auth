<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Bageur\Auth\model\action;

class CreateBgrActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_action', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_id')->index();
            $table->string('nama')->nullable();
            $table->string('route')->nullable();
            $table->string('icon');
            $table->string('icon_vendor')->default('mdi');
            $table->boolean('status')->default(true);
            $table->boolean('show')->default(true);
            $table->double('urutan');
            $table->timestamps();
        });

        // $action                         = new action;
        // $action->id                     = 1;
        // $action->urutan                 = 1;
        // $action->menu_id                = 3;
        // $action->nama                   = 'submenu';
        // $action->route                  = 'pengaturan-menu-submenu-id';
        // $action->icon                   = 'menu';
        // $action->save();

        // $action                         = new action;
        // $action->id                     = 2;
        // $action->urutan                 = 2;
        // $action->menu_id                = 3;
        // $action->nama                   = 'action';
        // $action->route                  = 'pengaturan-menu-action-id';
        // $action->icon                   = 'access-point';
        // $action->save();

        // $action                         = new action;
        // $action->id                     = 3;
        // $action->urutan                 = 3;
        // $action->menu_id                = 3;
        // $action->nama                   = 'delete';
        // $action->icon                   = 'delete-circle';
        // $action->save();

        // $action                         = new action;
        // $action->id                     = 4;
        // $action->urutan                 = 4;
        // $action->menu_id                = 3;
        // $action->nama                   = 'edit';
        // $action->icon                   = 'clipboard-edit';
        // $action->route                  = 'pengaturan-menu-edit';
        // $action->save();

        // $action                         = new action;
        // $action->id                     = 5;
        // $action->urutan                 = 5;
        // $action->menu_id                = 3;
        // $action->nama                   = 'add';
        // $action->icon                   = 'plus-box';
        // $action->route                  = 'pengaturan-menu-add';
        // $action->save();

        // $action                         = new action;
        // $action->id                     = 6;
        // $action->urutan                 = 6;
        // $action->menu_id                = 3;
        // $action->nama                   = 'sub menu add';
        // $action->icon                   = 'plus-box';
        // $action->route                  = 'pengaturan-menu-submenu-id-add';
        // $action->save();

        // $action                         = new action;
        // $action->id                     = 7;
        // $action->urutan                 = 7;
        // $action->menu_id                = 3;
        // $action->nama                   = 'add action';
        // $action->icon                   = 'plus-box';
        // $action->route                  = 'pengaturan-menu-action-id-add';
        // $action->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bgr_action');
    }
}
