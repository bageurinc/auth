<?php

namespace Bageur\Auth\Model;

use Illuminate\Database\Eloquent\Model;

class ind_provinsi extends Model
{
    protected $table   = 'bgr_indonesia_provinsi';

    public function kota()
    {
        return $this->hasMany('Bageur\Auth\Model\ind_kota','id_prov','id');
    }
    public function scopeKondisi($query,$id = null)
    {
    	if(!empty($id)){
    		$query->with(['kota']);
    		return $query->where('id',$id)->first();
    	}else{
    		return $query->get();
    	}
    }
}
