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
    public function scopeDatatable($query,$request,$page=12)
    {
        $search       = ["nama"];
        $searchqry    = '';

        $searchqry = "(";
        foreach ($search as $key => $value) {
            if($key == 0){
                $searchqry .= "lower($value) like '%".strtolower($request->search)."%'";
            }else{
                $searchqry .= "OR lower($value) like '%".strtolower($request->search)."%'";
            }
        }

        $searchqry .= ")";
        if(@$request->sort_by != null){
            $explode = explode('.', $request->sort_by);
                $query->orderBy($explode[0],$explode[1]);
        }else{
                $query->orderBy('created_at','desc');
        }
        $query->whereRaw($searchqry);

        if($request->get == 'all'){
            if(!empty($request->id)){
                return $query->find($request->id);
            }else{
                return $query->get();
            }
        }else{
                return $query->paginate($page);
        }

    }
}
