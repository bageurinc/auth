<?php

namespace Bageur\Auth\Model;

use Illuminate\Database\Eloquent\Model;
use Bageur\Auth\Processors\Helper;

class level extends Model
{
    protected $table   = 'bgr_level';
    protected $appends = ['avatar'];
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
    public function getAvatarAttribute() {
        return Helper::avatar($this->nama);
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
