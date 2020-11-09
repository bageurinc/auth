<?php

namespace Bageur\Auth\Model;

use Illuminate\Database\Eloquent\Model;
use Bageur\Auth\Processors\Helper;

class level extends Model
{
    protected $table   = 'bgr_level';
    protected $appends = ['avatar'];
 
    public function getAvatarAttribute() {
        return Helper::avatar($this->nama);
    }
    public function scopeSuperadmin($query)
    {
        $super_admin = \Auth::user()->level->super_admin;
        if($super_admin != 1){
           $query->where('super_admin',0);
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
        if(@$request->sort_by){
            if(@$request->sort_by != null){
                $explode = explode('.', $request->sort_by);
                 $query->orderBy($explode[0],$explode[1]);
            }else{
                  $query->orderBy('created_at','desc');
            }

             $query->whereRaw($searchqry);
        }else{
             $query->whereRaw($searchqry);
        }

        if($request->get == 'all'){
            return $query->get();
        }else{
                return $query->paginate($page);
        }

    }
}
