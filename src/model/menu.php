<?php

namespace Bageur\Auth\Model;

use Illuminate\Database\Eloquent\Model;
use Bageur\Auth\Processors\Helper;

class menu extends Model
{
    protected $table   = 'bgr_menu';
    protected $appends  = ['avatar']; 
    public function sub_menu()
    {
         return $this->hasMany('Bageur\Auth\model\menu','sub_id')->orderBy('urutan','asc');
    }  

    public function sub()
    {
         return $this->hasOne('Bageur\Auth\model\menu','id','sub_id');
    }  

    public function getAvatarAttribute() {
        return Helper::avatar($this->nama,$this->icon);
    }

    public function getBanyaksubAttribute() {
            return count($this->sub_menu);
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
        if(@$request->id){   
             $query->where('sub_id',$request->id);
        }else{
             $query->whereNull('sub_id');
        }
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
        if(@$request->category){
             $query->where('id_kategori',$request->category);
        }
        if($request->get == 'all'){
            return $query->get();
        }else{
                return $query->paginate($page);
        }

    }
}
