<?php

namespace Bageur\Auth\Model;

use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    protected $table   = 'bgr_level';
     public function fullmenu()
    {
         return $this->hasMany('Bageur\Auth\model\level_menu','id_level')
         			 ->whereNull('bgr_menu.sub_id')
         			 ->where('bgr_menu.status',1)
                     ->where('bgr_level_menu.view',true)
         			 ->whereNull('bgr_level_menu.id_submenu')
          			 ->with('submenu')
          			 ->orderBy('bgr_menu.urutan','asc')
         			 ->join('bgr_menu','bgr_menu.id','bgr_level_menu.id_menu');
         			 // ->with('menu');
    }   
}
