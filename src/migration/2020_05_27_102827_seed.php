<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Bageur\Auth\model\menu;
use Bageur\Auth\model\action;
use Bageur\Auth\model\level_akses;
use Bageur\Auth\model\level_akses_action;

class seed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

$bgr_action = array(
  array('id' => '1','menu_id' => '3','nama' => 'submenu','route' => 'pengaturan-menu-submenu-id','icon' => 'menu','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '1','created_at' => '2020-11-09 15:58:01','updated_at' => '2020-11-09 15:58:01'),
  array('id' => '2','menu_id' => '3','nama' => 'action','route' => 'pengaturan-menu-action-id','icon' => 'access-point','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '2','created_at' => '2020-11-09 15:58:01','updated_at' => '2020-11-09 15:58:01'),
  array('id' => '3','menu_id' => '3','nama' => 'delete','route' => NULL,'icon' => 'delete-circle','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '3','created_at' => '2020-11-09 15:58:01','updated_at' => '2020-11-09 15:58:01'),
  array('id' => '4','menu_id' => '3','nama' => 'edit','route' => 'pengaturan-menu-edit','icon' => 'clipboard-edit','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '4','created_at' => '2020-11-09 15:58:01','updated_at' => '2020-11-09 15:58:01'),
  array('id' => '5','menu_id' => '3','nama' => 'add','route' => 'pengaturan-menu-add','icon' => 'plus-box','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '5','created_at' => '2020-11-09 15:58:01','updated_at' => '2020-11-09 15:58:01'),
  array('id' => '6','menu_id' => '3','nama' => 'sub menu add','route' => 'pengaturan-menu-submenu-id-add','icon' => 'plus-box','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '6','created_at' => '2020-11-09 15:58:01','updated_at' => '2020-11-09 15:58:01'),
  array('id' => '7','menu_id' => '3','nama' => 'add action','route' => 'pengaturan-menu-action-id-add','icon' => 'plus-box','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '7','created_at' => '2020-11-09 15:58:01','updated_at' => '2020-11-09 15:58:01'),
  array('id' => '8','menu_id' => '6','nama' => 'add','route' => 'pengaturan-level-add','icon' => 'plus-box','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '0','created_at' => '2020-11-09 16:05:28','updated_at' => '2020-11-09 16:05:28'),
  array('id' => '9','menu_id' => '3','nama' => 'action delete','route' => 'pengaturan-menu-action-id-delete','icon' => 'delete','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '0','created_at' => '2020-11-09 16:09:07','updated_at' => '2020-11-09 16:09:07'),
  array('id' => '11','menu_id' => '3','nama' => 'submenu delete','route' => 'pengaturan-menu-submenu-id-delete','icon' => 'delete','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '0','created_at' => '2020-11-09 16:15:29','updated_at' => '2020-11-09 16:15:29'),
  array('id' => '12','menu_id' => '7','nama' => 'delete','route' => NULL,'icon' => 'delete-circle','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '0','created_at' => '2020-11-09 16:20:21','updated_at' => '2020-11-09 16:20:21'),
  array('id' => '13','menu_id' => '7','nama' => 'add','route' => 'pengaturan-level-add','icon' => 'plus-box','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '0','created_at' => '2020-11-09 16:22:19','updated_at' => '2020-11-09 16:22:19'),
  array('id' => '14','menu_id' => '7','nama' => 'edit','route' => 'pengaturan-level-edit-id','icon' => 'clipboard-edit','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '0','created_at' => '2020-11-09 16:22:42','updated_at' => '2020-11-09 16:22:42'),
  array('id' => '15','menu_id' => '7','nama' => 'setup','route' => 'pengaturan-level-setup-id','icon' => 'cog','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '0','created_at' => '2020-11-09 16:22:58','updated_at' => '2020-11-09 16:22:58'),
  array('id' => '16','menu_id' => '8','nama' => 'delete','route' => NULL,'icon' => 'delete-circle','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '0','created_at' => '2020-11-09 16:31:22','updated_at' => '2020-11-09 16:31:22'),
  array('id' => '17','menu_id' => '8','nama' => 'add','route' => 'pengaturan-admin-add','icon' => 'plus-box','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '0','created_at' => '2020-11-09 16:31:44','updated_at' => '2020-11-09 16:31:44'),
  array('id' => '18','menu_id' => '8','nama' => 'edit','route' => 'pengaturan-admin-edit-id','icon' => 'clipboard-edit','icon_vendor' => 'mdi','status' => '1','show' => '1','urutan' => '0','created_at' => '2020-11-09 16:32:11','updated_at' => '2020-11-09 16:32:11')
);


$bgr_level_akses = array(
  array('id' => '39','id_level' => '1','id_menu' => '1','sub_id' => NULL,'granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '40','id_level' => '1','id_menu' => '2','sub_id' => NULL,'granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '41','id_level' => '1','id_menu' => '3','sub_id' => '40','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '42','id_level' => '1','id_menu' => '7','sub_id' => '40','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '43','id_level' => '1','id_menu' => '8','sub_id' => '40','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '44','id_level' => '1','id_menu' => '9','sub_id' => '40','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44')
);

$bgr_level_akses_action = array(
  array('id' => '94','id_level_akses' => '41','id_action' => '1','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '95','id_level_akses' => '41','id_action' => '2','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '96','id_level_akses' => '41','id_action' => '3','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '97','id_level_akses' => '41','id_action' => '4','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '98','id_level_akses' => '41','id_action' => '5','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '99','id_level_akses' => '41','id_action' => '6','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '100','id_level_akses' => '41','id_action' => '7','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '101','id_level_akses' => '41','id_action' => '9','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '102','id_level_akses' => '41','id_action' => '11','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '103','id_level_akses' => '42','id_action' => '12','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '104','id_level_akses' => '42','id_action' => '13','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '105','id_level_akses' => '42','id_action' => '14','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '106','id_level_akses' => '42','id_action' => '15','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '107','id_level_akses' => '43','id_action' => '16','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '108','id_level_akses' => '43','id_action' => '17','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44'),
  array('id' => '109','id_level_akses' => '43','id_action' => '18','granted' => '1','created_at' => '2020-11-09 16:47:44','updated_at' => '2020-11-09 16:47:44')
);

$bgr_menu = array(
  array('id' => '1','sub_id' => NULL,'nama' => 'Home','icon' => NULL,'sub_nama' => NULL,'judul' => 'Home','link' => 'home','seo_link' => 'home','urutan' => '1','status' => '1','super_admin' => '0','created_at' => '2020-11-09 15:58:01','updated_at' => '2020-11-09 15:58:01'),
  array('id' => '2','sub_id' => NULL,'nama' => 'pengaturan','icon' => NULL,'sub_nama' => NULL,'judul' => 'pengaturan','link' => 'pengaturan','seo_link' => 'pengaturan','urutan' => '2','status' => '1','super_admin' => '0','created_at' => '2020-11-09 15:58:01','updated_at' => '2020-11-09 16:04:35'),
  array('id' => '3','sub_id' => '2','nama' => 'Menu','icon' => NULL,'sub_nama' => NULL,'judul' => 'Menu','link' => 'pengaturan-menu','seo_link' => 'pengaturan-menu','urutan' => '1','status' => '1','super_admin' => '0','created_at' => '2020-11-09 15:58:01','updated_at' => '2020-11-09 15:58:01'),
  array('id' => '7','sub_id' => '2','nama' => 'level','icon' => NULL,'sub_nama' => NULL,'judul' => 'level','link' => 'pengaturan-level','seo_link' => 'pengaturan-level','urutan' => '2','status' => '1','super_admin' => '0','created_at' => '2020-11-09 16:09:52','updated_at' => '2020-11-09 16:09:52'),
  array('id' => '8','sub_id' => '2','nama' => 'admin user','icon' => NULL,'sub_nama' => NULL,'judul' => 'admin user','link' => 'pengaturan-admin','seo_link' => 'pengaturan-admin','urutan' => '3','status' => '1','super_admin' => '0','created_at' => '2020-11-09 16:31:03','updated_at' => '2020-11-09 16:31:03'),
  array('id' => '9','sub_id' => '2','nama' => 'perusahaan','icon' => NULL,'sub_nama' => NULL,'judul' => 'perusahaan','link' => 'pengaturan-perusahaan','seo_link' => 'pengaturan-perusahaan','urutan' => '4','status' => '1','super_admin' => '0','created_at' => '2020-11-09 16:47:37','updated_at' => '2020-11-09 16:47:37')
);
    
  foreach ($bgr_menu as $key => $value) {
      $menu                     = new menu;
      $menu->id                 = $value['id'];
      $menu->sub_id                 = $value['sub_id'];
      $menu->nama                 = $value['nama'];
      $menu->icon                 = $value['icon'];
      $menu->sub_nama                 = $value['sub_nama'];
      $menu->judul                 = $value['judul'];
      $menu->link                 = $value['link'];
      $menu->seo_link                 = $value['seo_link'];
      $menu->urutan                 = $value['urutan'];
      $menu->status                 = $value['status'];
      $menu->super_admin                 = $value['super_admin'];
      $menu->save();
    }

  foreach ($bgr_action as $key => $value) {
      $menu                     = new action;
      $menu->id                 = $value['id'];
      $menu->menu_id                 = $value['menu_id'];
      $menu->nama                 = $value['nama'];
      $menu->route                 = $value['route'];
      $menu->icon                 = $value['icon'];
      $menu->icon_vendor                 = $value['icon_vendor'];
      $menu->status                 = $value['status'];
      $menu->show                 = $value['show'];
      $menu->urutan                 = $value['urutan'];
      $menu->save();
    }

  foreach ($bgr_level_akses as $key => $value) {
      $menu                     = new level_akses;
      $menu->id                 = $value['id'];
      $menu->id_level                 = $value['id_level'];
      $menu->id_menu                 = $value['id_menu'];
      $menu->sub_id                 = $value['sub_id'];
      $menu->granted                 = $value['granted'];
      $menu->save();
    }
  foreach ($bgr_level_akses_action as $key => $value) {
      $menu                     = new level_akses_action;
      $menu->id                 = $value['id'];
      $menu->id_level_akses                 = $value['id_level_akses'];
      $menu->id_action                 = $value['id_action'];
      $menu->granted                 = $value['granted'];
      $menu->save();
    }
        
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
