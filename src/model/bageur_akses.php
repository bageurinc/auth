<?php

namespace Bageur\Auth\Model;

use Illuminate\Database\Eloquent\Model;
use Bageur\Auth\Processors\Helper;
class bageur_akses extends Model
{
    protected $table   = 'bageur_akses';
    protected $appends = ['is_granted','avatar'];

    protected $hidden = [
        'granted'
    ];
     public function sub_menu()
    {
         return $this->hasMany('Bageur\Auth\model\bageur_akses','sub_id')->with('action')->orderBy('urutan','asc');
    }  

    public function getAvatarAttribute() {
        return Helper::avatar($this->nama,$this->icon);
    }
    
    public function action()
    {
         return $this->hasMany('Bageur\Auth\model\bageur_akses_action','id_level_akses');
    }  

    public function getIsGrantedAttribute()
    {
    	if($this->granted == '1'){
    		return true;
    	}else{
    		return false;
    	}
    }

    public function scopeSuperadmin($query)
    {
        $super_admin = \Auth::user()->level->super_admin;
        if($super_admin != 1){
           $query->where('super_admin',0);
        }
    }
    public function scopeDatatable($query)
    {
         $query->whereNull('sub_id');
         return $query->get();

    }
}
