<?php

namespace Bageur\Auth\Model;

use Illuminate\Database\Eloquent\Model;
use Bageur\Auth\Processors\helper;
class level_menu extends Model
{
    protected $table   = 'bgr_level_menu';
    public function submenu()
    {
         return $this->hasMany('Bageur\Auth\model\level_menu','id_submenu','id_menu')
         			 ->where('bgr_level_menu.view',true)
         			 ->join('bgr_menu','bgr_menu.id','bgr_level_menu.id_menu');
    }   
    public function getAvatarAttribute() {
        return helper::avatar($this->nama,$this->icon);
    }
}
